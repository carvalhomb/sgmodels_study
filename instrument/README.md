# Set up the online study

To set up the online study, you will need:

- Limesurvey 2.05+
- A web server running PHP+MySQL
- A Google account

## 1) Import templates into Google Docs

Import the four files from the *templates* folder into Google Docs, making sure you convert them to Google's format.

## 2) Make copies of the Google Docs templates

You will need one copy of each Google template for each participant of the survey, so make sure you have enough files. Make sure these files can be edited without authentication and that they are published to the web (see https://support.google.com/docs/answer/37579?hl=en).

OBS: This is a very laborous step that can get easier if you know how to use Google Drive API to get the document IDs and set the sharing and publishing settings. Check the API at https://developers.google.com/drive/v2/reference/. You can use the Python script gdrive.py to help in this step.

## 3) Create the MySQL table in your MySQL server

Use the *survey_db.sql* file to create the database table that the script needs to run.

## 4) Link the Google documents to the MySQL table

For each set of templates in Google, you will need to add the document ID (a long, hash-loooking string) to the appropriate column in the MySQL table. Something like:

``` INSERT INTO `atmsg_db`.`docs` (`id`, `atmsg_diagram`, `atmsg_table`, `lmgm_diagram`, `lmgm_table`, `token`) VALUES (NULL, 'a', 'b', 'c', 'd', NULL); ```

Substitute a, b, c and d for the actual id of the Google Spreadsheet/Google Draw. Leave the "token" column as NULL, since this value will be updated by the script once the participant accesses the templates for the first time.

If you know how to use the Google Drive API, the file gdrive.py can help you generate the SQL commands above.

## 5) Install the PHP files

Upload all the files in the *PHP* folder to a webserver running PHP. Note down the full URL to access the PDFs and the PHP files.

## 6) Update the Limesurvey lss file

Open the lss file with a powerful text editor (e.g. Notepad++). Use search/replace to substitute all the instances of the text "http://YOUR_WEB_SERVER" with the URL of your server where the PHP and PDF files can be accessed.

## 7) Import the Limesurvey lss file into Limesurvey

Import the .lss file (*questionnaire* folder) into Limesurvey. Adjust survey settings as necessary.


## 8) Update the config file in your webserver

Rename the file *config-sample.php* to *config.php* and adjust the settings according to your Limesurvey and your database server.

