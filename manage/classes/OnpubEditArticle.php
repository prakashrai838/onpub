<?php

/**
 * @author {@link mailto:corey@onpub.com Corey H.M. Taylor}
 * @copyright Onpub (TM). Copyright 2012, Onpub.com.
 * {@link http://onpub.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * Version 2
 * @package onpubgui
 */
class OnpubEditArticle
{
  private $pdo;
  private $oarticle;

  function __construct(PDO $pdo, OnpubArticle $oarticle)
  {
    $this->pdo = $pdo;
    $this->oarticle = $oarticle;
  }

  public function display()
  {
    $oarticles = new OnpubArticles($this->pdo);
    $owebsites = new OnpubWebsites($this->pdo);
    $osamaps = new OnpubSAMaps($this->pdo);
    $osections = new OnpubSections($this->pdo);
    $oimages = new OnpubImages($this->pdo);

    try {
      $queryOptions = new OnpubQueryOptions();
      $queryOptions->includeAuthors = TRUE;
      $this->oarticle = $oarticles->get($this->oarticle->ID, $queryOptions);

      $queryOptions = new OnpubQueryOptions();
      $queryOptions->orderBy = "fileName";
      $queryOptions->order = "ASC";
      $images = $oimages->select($queryOptions);

      $queryOptions = new OnpubQueryOptions();
      $queryOptions->orderBy = "name";
      $queryOptions->order = "ASC";
      $websites = $owebsites->select($queryOptions);

      $queryOptions = new OnpubQueryOptions();
      $samaps = $osamaps->select($queryOptions, NULL, $this->oarticle->ID);
    }
    catch (PDOException $e) {
      throw $e;
    }

    $author = $this->oarticle->authors;

    if (sizeof($author)) {
      $author = $author[0];
    }
    else {
      $author = new OnpubAuthor();
    }

    $widget = new OnpubWidgetHeader("Article " . $this->oarticle->ID . " - " . $this->oarticle->title, ONPUBAPI_SCHEMA_VERSION, $this->pdo);
    $widget->display();

    en('<form id="onpub-form" action="index.php" method="post">');
    en('<div>');

    en('<p><textarea rows="25" cols="100" name="content">' . htmlentities($this->oarticle->content) . '</textarea></p>');

    if (file_exists('ckeditor/ckeditor_php5.php')) {
      include './ckeditor/ckeditor_php5.php';
      $config = array();
      $events = array();

      $ck = new CKEditor();
      $ck->basePath = 'ckeditor/';

      $config['height'] = 350;
      $config['uiColor'] = '#eff0f0';
      $config['resize_dir'] = 'vertical';

      if (file_exists(ONPUBGUI_YUI_DIRECTORY)) {
        $config['contentsCss'] = array('ckeditor/contents.css', ONPUBGUI_YUI_DIRECTORY . 'cssgrids/grids-min.css', 'css/ckeditor.css');
      }
      else {
        $config['contentsCss'] = array('ckeditor/contents.css', 'http://yui.yahooapis.com/' . ONPUBGUI_YUI_VERSION . '/build/cssgrids/grids-min.css', 'css/ckeditor.css');
      }

      $events['instanceReady'] = 'function (ev) {
        var w = ev.editor.dataProcessor.writer;
        w.indentationChars = "  ";
        w.selfClosingEnd = ">";
        w.setRules("div", {breakBeforeClose: true});
      }';

      $ck->replace('content', $config, $events);
    }

    en('<div class="yui3-g">');

    en('<div class="yui3-u-1-2">');

    en('<h3 class="onpub-field-header">Title</h3><p><input type="text" maxlength="255" size="40" name="title" value="' . htmlentities($this->oarticle->title) . '"></p>');

    en('</div>');

    en('<div class="yui3-u-1-2">');

    en('<h3 class="onpub-field-header">Author</h3><p><input type="text" maxlength="255" size="40" name="displayAs" value="' . htmlentities($author->displayAs) . '"></p>');

    en('</div>');

    en('</div>');

    en('<div class="yui3-g">');

    en('<div class="yui3-u-1-2">');
    $widget = new OnpubWidgetSections();
    $widget->websites = $websites;
    $widget->osections = $osections;
    $widget->samaps = $samaps;
    $widget->display();
    en('</div>');

    en('<div class="yui3-u-1-2">');
    $widget = new OnpubWidgetImages("Image", $this->oarticle->imageID, $images);
    $widget->display();
    en('</div>');

    en('</div>');

    if ($this->oarticle->url) {
      $go = ' <a href="' . $this->oarticle->url . '" target="_blank"><img src="' . ONPUBGUI_IMAGE_DIRECTORY . 'world_go.png" border="0" align="top" alt="Go" title="Go" width="16" height="16"></a>';
    }
    else {
      $go = '';
    }

    en('<div class="yui3-g">');

    en('<div class="yui3-u-1-2">');
    en('<h3 class="onpub-field-header">Static Link</h3><p><small>The Frontend will link this article to the path or URL entered below.<br>Leave blank to use auto-generated Frontend URLs.</small><br><input type="text" maxlength="255" size="40" name="url" value="' . htmlentities($this->oarticle->url) . '">' . $go . '</p>');
    en('</div>');

    en('<div class="yui3-u-1-2">');

    if (sizeof($samaps))
    {
      $websitesMap = array();

      foreach ($websites as $website)
      {
        $websitesMap["{$website->ID}"] = $website;
      }

      $sections = array();
      $articleIDs = array();

      foreach ($samaps as $samap)
      {
        $section = $osections->get($samap->sectionID);

        if ($section && isset($websitesMap["{$section->websiteID}"]))
        {
          $website = $websitesMap["{$section->websiteID}"];

          if ($website->url)
          {
            $sections[] = $section;
            $articleIDs[] = $samap->articleID;
          }
        }
      }

      if (sizeof($sections))
      {
        $urlLabel = (sizeof($sections) > 1) ? 'URLs' : 'URL';

        en('<h3 class="onpub-field-header">Frontend ' . $urlLabel . '</h3>');

        en('<p>');
        en('<small>This article is displayed by the Frontend at the ' . $urlLabel . ' listed below.</small><br>');

        for ($i = 0; $i < sizeof($sections); $i++)
        {
          $section = $sections[$i];
          $website = $websitesMap["{$section->websiteID}"];
          
          $frontendURL = addTrailingSlash($website->url) . 'index.php?s=' . $section->ID . '&amp;a=' . $articleIDs[$i];
          en('&bull; <a href="' . $frontendURL . '" target="_blank">' . $frontendURL . '</a>');

          if (($i + 1) != sizeof($sections))
          {
            en('<br>');
          }
        }

        en('</p>');
      }
    }

    en('</div>');

    en('</div>');

    $widget = new OnpubWidgetDateCreated($this->oarticle->getCreated());
    $widget->display();

    $modified = $this->oarticle->getModified();

    en('<h3 class="onpub-field-header">Modified</h3><p>' . $modified->format('M j, Y g:i:s A') . '</p>');

    en('<input type="submit" value="Save"> <input type="button" value="Delete" id="deleteArticle">');

    en('<input type="hidden" name="articleID" id="articleID" value="' . $this->oarticle->ID . '">');
    en('<input type="hidden" name="authorID" value="' . $author->ID . '">');
    en('<input type="hidden" name="authorImageID" value="' . $author->imageID . '">');
    en('<input type="hidden" name="lastDisplayAs" value="'  . htmlentities($author->displayAs) . '">');
    en('<input type="hidden" name="onpub" value="EditArticleProcess">');

    en('</div>');
    en('</form>');

    $widget = new OnpubWidgetFooter();
    $widget->display();
  }

  public function validate()
  {
    if (!$this->oarticle->title) {
      $this->oarticle->title = NULL;
      return FALSE;
    }

    return TRUE;
  }

  public function process()
  {
    $oarticles = new OnpubArticles($this->pdo);

    try {
      $oarticles->update($this->oarticle, TRUE);
    }
    catch (PDOException $e) {
      throw $e;
    }
  }

  public function delete()
  {
    $oarticles = new OnpubArticles($this->pdo);

    try {
      $oarticles->delete($this->oarticle->ID);
    }
    catch (PDOException $e) {
      throw $e;
    }
  }
}
?>