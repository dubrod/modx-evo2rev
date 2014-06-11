#Upgrade from Evo to Revo with a cPanel Backup

##The Setup

1. Create your cPanel Backup of the **Home Directory**
2. Open PHPmyadmin
3. Export your Evo DB Table "modx_site_content" as a CSV file. 
  - Check "Remove carriage return/line feed characters within columns"
  - Check "Put columns names in first row"
4. Open this CSV in text edit
  - Find your contents ""
  - Replace with \" so we escape the content quotes
  - Find ,,
  - Check these results to make sure double commas are only in your database headers. If you have double commas in your content field please edit those out manually.
  - Replace with ,"",
  - Save

4. Create a folder to host our Github files on a testing server, the new server, or local server, we call our **migrate**
5. Upload your modx_site_content.csv to this folder along with *migration-expert.php* and *update-tags.php*
6. Run *update-tags.php*

---

##Content Editing

The *update-tags* script removes line breaks from content for you but you'll need to go add them back in at the end of the the data rows.

1. Open TextEdit and hit enter after "hidemenu" so the next line starts with "1"
2. Next i did a find for "document" since that is going to be the 2nd value for every line, then hit enter
before the number (id) that is before "document". thats starts a new record
3. Save and re-upload *modx_site_content_updated.csv* to the folder

---

###Install MODX Revo 2.3

---

##Import to the Database

Time for some insertion magic, and hopefully a bit of content creation

1. EDIT migration-expert.php
2. Insert your database info on line 2 
3. Run the file.

###Open your MODX Manager and view your glorious victory over Manual Content Migration!

> If no errors delete this **migrate** folder unless your going to do templates now.

---

##Assets

Upload your assets/template files to the new server

---

##Categories

MODX Revo now has a *Parent* Column but you can still copy/paste the SQL statement from the EVO dump.

Example:
```
INSERT INTO `modx_categories` (`id`, `category`) VALUES (1,'Demo Content'),(2,'Login'),(3,'Manager and Admin'),(4,'Search'),(5,'Content'),(6,'Forms'),(7,'Navigation'),(8,'Custom');
```

---

##Templates

Same Scenario.

1. Open PHPmyadmin
2. Export your Evo DB Table "modx_site_templates" as a CSV file.
3. Repeat steps above to get CSV ready
4. just change my Migrate files to look for *_templates* not *_content* related files, change the names of the .php to avoid cache issues.
  - update-tags.php - line 3 & line 27
  - migration-expert.php - line 12 & line 28
  - change the **$insert** line 54 to:

```
$insert = "INSERT INTO `modx_site_templates` (`id`, `templatename`, `description`, `editor_type`, `category`, `icon`, `template_type`, `content`, `locked`) VALUES ('".$csv_row[id]."','".$csv_row[templatename]."','".$csv_row[description]."','".$csv_row[editor_type]."','".$csv_row[category]."','".$csv_row[icon]."','".$csv_row[template_type]."','".$csv_row[content]."','".$csv_row[locked]."')";
```

5. Truncate your revo *modx_site_templates* table
6. run your new migration-expert php 
7. If they don't show up in the manager but the page renders it is most likely because of a category ID setting.

> Depending on your # of templates it would be arguably quicker to just do it manually. Just make sure the template ID in the database is the same since resources call ID's not Names.

---

##Chunks

The *modx_site_htmlsnippets* table has many new additional columns

Same Scenario.

1. Open PHPmyadmin
2. Export your Evo DB Table "modx_site_htmlsnippets" as a CSV file.
3. escape double quotes and make sure double comma column separations are seen properly with ,"",
4. alter update-tags.php
5. run
6. download _updated
7. re-insert line breaks for header row and data rows
8. upload 
9. duplicate migration-expert.php and edit line 12 & line 28
10. New **$insert**:
```
$insert = "INSERT INTO `modx_site_htmlsnippets` (`id`, `name`, `description`, `editor_type`, `category`, `cache_type`, `snippet`, `locked`) VALUES ('".$csv_row[id]."','".$csv_row[name]."','".$csv_row[description]."','".$csv_row[editor_type]."','".$csv_row[category]."','".$csv_row[cache_type]."','".$csv_row[snippet]."','".$csv_row[locked]."')";
```
11. run 
12. check your manager, live site for renderings

---

##Ditto

Changing that standard Parent #2 Ditto snippet to **getResources**

```[[Ditto? &parents=`2` &display=`2` &removeChunk=`Comments` &tpl=`ditto_blog` &paginate=`1` &extenders=`summary,dateFilter` &paginateAlwaysShowLinks=`1` &tagData=`documentTags`]]
```

```[[getResources? &parents=`2` &tpl=`ditto_blog`]]```

Visit http://rtfm.modx.com/extras/revo/getresources for more information

---

##eForm

Changing eForm to FormIt

```
[!eForm? 
&formid=`ContactForm` 
&subject=`[[+subject]]` 
&to=`[(emailsender)]` 
&ccsender=`1` 
&tpl=`ContactForm` 
&report=`ContactFormReport` 
&invalidClass=`invalidValue` 
&requiredClass=`requiredValue` 
&cssStyle=`ContactStyles` 
&gotoid=`46`  
!]
```

to

```
[[!FormIt?
   &hooks=`email,redirect`
   &emailTpl=`ContactFormReport`
   &emailTo=`wayne@modx.com`
   &redirectTo=`46`
   &validate=`
      name:required,
      email:email:required,
      subject:required,
      text:required:stripTags`
]]
[[$ContactForm]]
```

On the **Contact Form** inputs:

```
eform="Your Name::1:"
```

to

```
value="[[!+fi.name]]"
```

and change the `id=cf...` name structure

visit http://rtfm.modx.com/extras/revo/formit/formit.tutorials-and-examples/formit.examples.simple-contact-page for more examples of the form HTML

`[[+validationmessage]]` becomes ```[[!+fi.error_message:notempty=`<p>[[!+fi.error_message]]</p>`]]```

> the ContactFormReport aka Email Template should have placeholders already updated if you did the update-tags.php on your chunks.

---



