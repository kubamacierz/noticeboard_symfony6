noticeboard
===========

This is a project of Notice Board. Created in Symfony 6.3 on php 8.1.

<p><b>Short description:</b>gi</p>
There is a possibility to add a notice on board which are possible to browse both by logged and not-logged users. When you log in you can also add new notice which is valid for one week. As regular user you can also browse, edit (except of expiration date) your notices. As admin user additionally you can browse (including expired), edit(including expiration date) and delete all notices.

<b>Requirements:</b>
<p>-php 8.1</p>
<p>-composer</p>
<p>-postgreSQL</p> 

<p><b>How to install on Linux-Ubuntu:</b></p>
<p>-download this repo</p>
<p>-run composer install</p>
<p>-fill .env.local file with your database credentials</p>
<p>-hit command "bin/console doctrine:database:create"</p>
<p>-hit command "bin/console doctrine:migrations:diff"</p>
<p>-hit command "bin/console doctrine:migrations:migrate"</p>
<p>-hit command "symfony server:start"</p>
<p>-Have fun using this app</p>
