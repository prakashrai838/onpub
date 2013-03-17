Onpub
=====

Introduction
------------
Onpub is a web content management system (CMS) designed for those with intermediate to advanced web development skills wanting to create custom, dynamic websites that are easy to update and maintain.

All Onpub content is stored in a fast and reliable MySQL database backend. There are many ways to customize and extend Onpub's default design and functionality via open-standard web development tools and techniques.

Onpub is ideal for those with no desire to implement a CMS from scratch, but still need a custom, yet agile solution. Onpub tightly integrates many widely used third-party web apps and scripts in to one coherent system to build further upon.

Onpub was created by Corey Taylor in Boston, MA. Corey is still the sole author and maintainer of the source code.

Key Features
------------ 
### Mobile device and touch-screen friendly

Onpub uses responsive web design techniques in order to automatically adapt its frontend layout to smaller screens, such as those on modern smartphones. No re-directs or separate mobile micro sites required.

### Fully customizable frontend

Every Onpub download includes a frontend template that can be fully customized to suit your needs. This customization is done via a combination of CSS, PHP, and JavaScript code changes. All code is fully web-standards compliant and open source.

### YUI integration

The frontend interface tightly integrates the Yahoo User Interface (YUI) JavaScript and CSS libraries, making it easy to write cross-browser compatible HTML markup and DHTML JavaScript code.

### Cross-browser compatible

Onpub supports all YUI Target Environments. This means that the sites you build with Onpub will have a high level of compatibility with all modern web browsers. Your site will look and behave exactly the same way, regardless of whether you are viewing it in IE, Chrome, or Firefox. This includes modern mobile browsers as well.

### Easy HTML editing

The content management interface tightly integrates the widely used HTML editor, CKEditor. CKEditor enables both "what you see is what you get" HTML editing, and also HTML and JavaScript source code editing all within one easy to use, word processor-like interface.

### Quick content updates

Onpub extends CKEditor to make it even easier to use by enabling AJAX -based saving, so that updating your content does not require a full page reload. This allows you to save your changes without losing your cursor position. This also allows you to easily undo unwanted changes and then re-save.

### Unsaved change detection

When editing your articles with Onpub, you will be warned of unsaved changes if you attempt to navigate away from the page before saving your changes. This feature makes it much less likely that you'll ever lose data due to accidental mouse clicks.

### Simple account management

Your MySQL user account is your Onpub login. There's no need to setup a separate user account to start using Onpub to build sites. Also, you can connect to any database that your MySQL account has access to, making it easy to work with multiple content databases within one login session.

### Free and open-source software

Onpub is licensed under version 2 of the GNU GPL. This means you are free to re-distribute all original source code changes, so long as you contribute any improvements to the application back to us. Onpub is developed openly via its GitHub project page.

Architecture
------------
Onpub consists of 3 main components: the Frontend, the Management Interface and the Application Programming Interface (API).

### Frontend

The Onpub frontend and the PHP, HTML, CSS, and JavaScript code it consists of, is what enables you to publish your Onpub-managed content to the Web. For example, the page you are reading this article on is automatically generated by the frontend code.

The frontend may be customized to suit your needs in several different ways:

* Via the use of custom CSS code
* By using several pre-defined automatic local PHP include files
* By programmatically extending the OnpubFrontend PHP object
* By uploading a custom logo and other image files

Some or all of the above methods can be used to create a frontend design and layout that is completely custom when compared with the out-of-the-box design.

### Management Interface

The management interface is where you log in with your MySQL user name and password in order to edit your site's content. This is where you will perform all updates to the content that is publicly displayed via your Onpub frontend.

Here are some examples of the type of functionality the management interface offers:

* Create and edit the Articles and Sections that make up the content and structure of your website
* Upload images to be displayed by your frontend
* Re-organize and re-order the structure of your site by creating sub-sections and by linking articles to multiple sections, if required

The management interface is designed to make it as easy as possible to edit all of your site's HTML and JavaScript based content. Any saved edits you make via the management interface are automatically displayed by the frontend interface the next time the page is reloaded in a reader's web browser.

This is the component that makes Onpub a dynamic content management system. Meaning there's no intermediate steps to publish changes to the web. Changes are published automatically as soon as they are saved by you via your Onpub management interface. This makes it very fast to make content edits and additions to your Onpub-powered websites.

### Application Programming Interface

The 3rd component of Onpub's architecture is its application programming interface, also known as, OnpubAPI. OnpubAPI consists of PHP code that simplifies communication with a MySQL database in order to create, read, update, and delete Onpub site content.

Both the management interface and the frontend use this API as a common interface to communicate with the MySQL database server.

The frontend uses OnpubAPI primarily in a read-only fashion. For example, when a reader loads your frontend's home page in their web browser, the frontend uses OnpubAPI to retrieve the home page content from the database in order to display it.

The management interface uses OnpubAPI to not only read your site's content from the database, it also uses it to write changes back to the database, and also to delete existing content, if desired.

Onpub's API is also designed to be leveraged by other PHP developers to make it easy to access Onpub-managed data and display it, integrate it and otherwise manage it in creative new ways.

License
-------

Copyright © 2007-2011 Corey H.M. Taylor.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; version 2.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

See the GNU General Public License for more details.