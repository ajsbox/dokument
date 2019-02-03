<div class="row-fluid">
	<div class="span3">
		<ul class="nav nav-tabs nav-stacked">
          <li><a class="btn-nav" href="#installation"><i class="icon-chevron-right"></i> Installation</a></li>
          <li><a class="btn-nav" href="#upgrading"><i class="icon-chevron-right"></i> Upgrading</a></li>
          <li><a class="btn-nav" href="#adminPanel"><i class="icon-chevron-right"></i> Admin Panel</a></li>
          <li><a class="btn-nav" href="#generalManagement"><i class="icon-chevron-right"></i> General Management</a></li>
          <li><a class="btn-nav" href="#personalization"><i class="icon-chevron-right"></i> Page Personalization</a></li>
          <li><a class="btn-nav" href="#support"><i class="icon-chevron-right"></i> Support</a></li>
        </ul>
        <ul class="nav nav-tabs nav-stacked">
          <li><a class="btn-nav" href="#installation-support-plugin"><i class="icon-chevron-right"></i> Support Plugin Installation</a></li>
          <li><a class="btn-nav" href="#installation-gallery-plugin"><i class="icon-chevron-right"></i> Gallery Plugin Installation</a></li>
        </ul>
	</div>
	<div class="span9">
		<div class="home-box" style="padding: 15px; border-radius: 10px;">
		<h1 style="text-align: center; margin-bottom: 20px;">CMSLogik Documentation</h1>
		<p class="lead">Thank you for purchasing CMSLogik, below you will find documentation for this script. Please look it over, as
			common questions are most likely answered below.</p>
		</div>
		<hr>
		<div class="doc-section" id="installation">
			<h3>Installation:</h3>
			<p>An installation wizard is provided to make installation a breeze. However before we run the wizard, we need to edit a couple of files to make sure
				the script runs smoothly.
			<h4>Step 1:</h4>
			<p>Open the <b>application/config/database.php</b> file and edit the following lines.</p>
				<pre>
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'MYSQL USERNAME';
$db['default']['password'] = 'DB PASSWORD';
$db['default']['database'] = 'DB NAME';</pre>
			<h4>Optional:</h4>
			<p>If you are installing the script in a sub-directory, for example http://yourdomain.com/sub-directory/ you will 
				need to open the .htaccess file and add your directory like so:</p>
				<pre>
RewriteEngine on
RewriteCond $1 !^(index\.php|img|assets|js|css|robots\.txt)
RewriteRule ^(.*)$ /SUB-DIRECTORY-NAME-HERE/index.php/$1 [L]</pre>

			<p><strong>Note:</strong> If you are a godaddy customer, your .htaccess file should contain this instead:</p>
			<pre>
RewriteEngine on
RewriteCond $1 !^(index\.php|img|assets|js|css|robots\.txt)
RewriteRule ^(.*)$ /SUB-DIRECTORY-NAME-HERE/index.php?/$1 [L]</pre>
			<h4>Step 2:</h4>
			<p>Now we will need to open the <b>application/config/config.php</b> file and edit the following line:
				<pre>$config['encryption_key'] = 'PUT SOMETHING UNIQUE HERE';</pre>

			<h4>Step 3:</h4>
			<p>Upload the contents of your UserLogik folder to where it will reside on your server.

			<h4>Step 4:</h4>
			<p>Now simply head over to <b>http://yourdomain.com/script-directory-name/install</b>. Enter all the required details and hit <b>Install</b>.

			<h4>Step 5:</h4>
			<p>For secuirty reasons, please delete the <b>application/controllers/install.php</b> file.</p>

			<h4>Note:</h4>
			<p>If you would like to be able to edit files from within the admin control panel, please make sure that the following folders 
				have writting permissions.
				<ul>
					<li>application/<b>views</b></li>
					<li>application/views/<b>email</b>/</li>
					<li>application/views/<b>page</b>/</li>
				</ul>
			</p>

			<h4>Installation complete</h4>
			<p>That was easy, wasn't it? Now you can use your site, and login to the control panel with the credentials that you created.</p>
		</div>

		<div class="doc-section" id="upgrading">
			<h4>Upgrading CMSLogik</h4>
			<p>Upgrading to the new version is very easy. Simply replace your old application folder with the new one, leaving out the <b>config/database.php</b>
				file. Afterwards head over to http://YOURDOMAIN.com/PATH-TO-SCRIPT/install/update Ater the script finishes running you will be redirected back to the homepage. 
				Please remove <b>controllers/install.php</b> after upgrading/installing for security purposes.</p>
		</div>

		<div class="doc-section" id="adminPanel">
			<h4>Admin Panel:</h4>
			<p>Now that the script is up and running, we can login to the admin control panel and manage the website. To login 
				to the admin control panel, simply login like a regular user using your admin credentials. You should automatically be taken to 
				the dashboard after logging in.</p>

			<p>Here you can manage your entire website. Let's take a look at what each page does.</p>
			<h4>Settings:</h4>
			<p>The settings page has 3 options: General, Social, and Captcha settings.</p>
			<h5>General:</h5>
			<p>Here you can manage basic website settings. Anything from website title, to the default pages, and user levels.</p>
			<h5>Social:</h5>
			<p>In order to enable users to login to your website using Facebook or Twitter we need to go ahead and set-up applications on both websites.</p>
			<h6>Facebook:</h6>
			<p>Head over to the <a href="https://developers.facebook.com/">Facebook Developers Website</a> and create a new application. 
				Give your application a name, contact email, and the default URL. Also under <b>Select how your app integrates with Facebook</b> make sure you check 
				<b>Website with Facebook Login</b> and set your default site url. Now simply grab the App ID along with the App Secret and paste each into their 
				appropriate fields with the Social Settings Tab.</p>
			<h6>Twitter:</h6>
			<p>The Twitter set-up is similar, head over to the <a href="https://dev.twitter.com/">Twitter Developer Website</a> and set-up a new application. 
				Fill in the required fields, and you can leave the Callback URL field blank, as the URL is generated dynamically within the script. Now head over
				back to your Social Settings Tab and fill in the Consumer Key and Consumer Secret that were generated by Twitter for your application.</p>
			<h4>Manage Users:</h4>
			<p>Here you can manage registered users on your website. All the options are self explanetory and give you complete control over your users.</p>
			<h4>Email Users:</h4>
			<p>You have the ability to create an email template, and send it out to any user level you want. You can even select more than one, or all of them!</p>
			<h4>Email Templates:</h4>
			<p>You can create custom email templates to send out to your users. There are already 4 pre-made templates for basic site functions. You can edit them in any way you like. 
				When creating new templates, you have an array of shortcodes that you can use to personalize your emails.</p>
			<h4>Statistics:</h4>
			<p>You can view all time, as well as date range, statistics for your website.</p>
			<h4>Manage User Levels:</h4>
			<p>Here you can create, and edit user levels. Please note that out of the 3 created users levels by default, you should only edit the User one to your desire. 
				The admin and guest levels are reserved for appropriate functionality and should not be tempered with. We also did not include an ability to delete levels to prevent this from happening. 
				You are rather encouraged to edit existing levels, or create new ones.</p>
			<h4>Manage Menus:</h4>
			<p>Here you can manage your top website menu including the name, location, and order.</p>
			<h4>Manage Pages:</h4>
			<p>This section lets you create and manage pages on your website. Default website pages, such as login, registration, and the admin panel are stored in a different area under your views folder.</p>
		</div>
		<div class="doc-section" id="generalManagement">
			<h4>General Website Management:</h4>
			<h5>Header Logo/Text</h5>
			<p>You have the ability to use your own custom logo, or simply have a text based one. In order to upload your own image one, upload a logo.png file to
				/assets/img/ folder. Now head over to your control panel, general settings, and change the "Header Title" setting to 0(zero). This will enable your custom logo image.</p>
			<h5>Designing Pages:</h5>
			<p>UserLogik was built on a very powerful front-end css framework called <a href="http://twitter.github.com/bootstrap/">Bootstrap</a>. What this means, is that all the features 
				that Bootstrap has to offer, are also available for you to use on your website. This makes designing new pages a breeze. You may use any features you see in the Bootstrap documentation in your pages.</p>
			<h5>Managing Access:</h5>
			<p>User levels allow you to give and restrict access to any page you create. Simply add the user levels, that you want to allow access, to the pages you create.</p>
			<h5>Changing Website Appearance:</h5>
			<p>There are a lot of themes available for Bootstrap, you only need to simply replace bootstrap.css with your new Bootstraps theme css file and your in business with a different look.
				You can check out <a href="http://bootswatch.com/">Bootswatch</a> for some cool free themes.</p>
		</div>
		<div class="doc-section" id="personalization">
			<h4>Personalizing Your Pages:</h4>
			<p>UserLogik allows you to use PHP in the pages that you create. You have an option to personalize the pages you build with a helper function. Here is an example of how you might use it.</p>
			<pre>&lt;?php $user = $this->logik->user(); ?&gt;
Name: &lt;?php echo $user->name; ?&gt;
Username: &lt;?php echo $user->username; ?&gt;
Email: &lt;?php echo $user->email; ?&gt;</pre>
			<p>You can also easily retrieve any of your website settings:</p>
			<pre>&lt;?php $this->logik->setting('admin_email'); ?&gt;
//or
&lt;?php $this->logik->setting('site_title'); ?&gt;</pre>
		</div>
		<div class="doc-section" id="support">
			<h4>Getting Help</h4>
			<p>If you run into a problem, have a questions, or a suggestion please email us at themelogik@gmail.com</p>
		</div>
		<h1 style="text-align: center; margin-bottom: 20px;">CMSLogik Plugins Documentation</h1>
		<p class="lead">You will find the necessary documentation for your plugin below.</p>
		<hr>

		<div class="doc-section" id="installation-support-plugin">
			<h4>Support Plugin</h4>
			<p>Thank you for purchasing the support plugin, installation is very easy, so let's get started.<p>
			<h5>Upload Files</h5>
			<p>First you need to upload the neccesary files. In the folder that you have downloaded please upload the contents of the 
				<b>upload</b> folder to the destination of where you have installed CMSLogik.</p>
			<h5>Database Install</h5>
			<p>After the files have been uploaded, head over to http://YOUR-DOMAIN.com/PATH-TO-SCRIPT/support/install The script will perform 
				the neccesary changes. <b><i>Please note that you have to be logged in as admin for this to work.</i></b>
			<h5>File Permissions</h5>
			<p>In order for users to be able to upload files, you need to CHMOD the <b>support_files</b> folder to 777.</p>
			<h5>Enable the Module</h5>
			<p>Head over to your admin panel, manage modules, and enable the support module</p>
			<p>That is it, enjoy the plugin!</p>
		</div>

		<div class="doc-section" id="installation-gallery-plugin">
			<h4>Gallery Plugin</h4>
			<p>Thank you for purchasing the gallery plugin, let's get started.<p>
			<h5>Upload Files</h5>
			<p>First you need to upload the neccesary files. In the folder that you have downloaded please upload the contents of the 
				<b>upload</b> folder to the destination of where you have installed CMSLogik.</p>
				
			<h5>File Edits</h5>
			<p>Please open <strong>application/views/inc/header.php</strong> and find the following:</p>
				<pre>
&lt;link href="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/css/bootstrap.css" rel="stylesheet"&gt;</pre>
				<p>Right underneath paste this:</p>
				<pre>
&lt;link href="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/css/gal.cmslogik.css" rel="stylesheet"&gt;
&lt;link href="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/css/lightbox.css" rel="stylesheet"&gt;
&lt;link href="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/css/slicebox.css" rel="stylesheet"&gt;</pre>
			<p>Please open <strong>application/views/inc/footer.php</strong> and find the following:</p>
			<pre>
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/chosen.jquery.js"&gt;&lt;/script&gt;</pre>
			<p>Right underneath paste the following:</p>
			<pre>
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/modernizr.custom.46884.js"&gt;&lt;/script&gt;
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/jquery.slicebox.js"&gt;&lt;/script&gt;
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/gal.cmslogik.js"&gt;&lt;/script&gt;
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/lightbox.js"&gt;&lt;/script&gt;
&lt;script src="&lt;?php echo $this->logik->setting('default_url'); ?&gt;assets/js/isotope.js"&gt;&lt;/script&gt;</pre>
			<h5>Database Install</h5>
			<p>After the files have been uploaded, head over to http://YOUR-DOMAIN.com/PATH-TO-SCRIPT/admin/gallery/install The script will perform 
				the neccesary changes. <b><i>Please note that you have to be logged in as admin for this to work.</i></b>
			<h5>File Permissions</h5>
			<p>In order for you to be able to upload files, you need to CHMOD the <b>gal-images</b> <b>gal-images/slider</b> folders to 777.</p>
			<h5>Enable the Module</h5>
			<p>Head over to your admin panel, manage modules, and enable the support module</p>
			<p>That is it, enjoy the plugin!</p>
		</div>
	</div>
</div>