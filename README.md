# CN Base Theme

## Local Requirements
node  
npm  
composer  
wp-cli  

## Local Install Process
Create empty directory for WP  
Clone theme into folder  
Open wp-cli.yaml  
Change settings for local  
Run ‘wp core download’  
Run ‘wp core config’  
Run ‘wp core install’  
Delete wp-cli.yml file  
Optional: change theme name  
Optional: Activate theme ‘wp theme activate themename’  
Optional: run ‘sudo rm -R .git’ to get rid of associations with ‘cntheme’  
Navigate to theme folder  
Open composer.json  
Change url for WP Migrate DB Pro (local is ok, but needs to be final url before deployment)  
If there are newer versions then update version numbers  
Run ‘composer install’ (this will install timber and update WP Migrate DB Pro)  
Run ’npm install’ 
Run ‘npm run watch’ or ’npm run production’ to compile assets