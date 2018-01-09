# 


# oc-security-plugin
A security layer for OctoberCMS   
*tl;dr SecOps is a plugin for OctoberCMS which adds several security features and a checklist for common Security Flaws*

## Installation
Pretty simple, just get it in the marketplace :)

## Features
*This plugin is stil under active development; so the feature list to*

- **FileChanges**
Detects changes in the filesystem, including changes in content by means of a file hash
- **Malware Scanner**    
Scan your codebase for known malware-patterns.
- **Headers**
Easily configure security headers like Content-Security-Policy headers
- **SecOps Check**
Check your OctoberCMS installation for common security holes or wrong settings; and even get tips on how to fix them!


### FileChanges
First step is to create a baseline of the current state of your OctoberCMS install. By default it uses the files in your install folder including sub-directories; but excluding frequently changed folders like: `storage` and `themes`. (Otherwise you would get notified by every change to eg a page.)

As the baseline is the status quo where we are checking against; its necessary to ‘update’ the baseline on every OctoberCMS or Plugin update. 

The baseline itself is stored in the database, it includes the  file path and a hash of the contents of the file. 

After creating a baseline the plugin will periodically crawl the directory and compare the files and their hashes.

If an Anamoly is being detected a notification will be sent. Off course you are able to define what should happen with this notification: sent an Email or post it in Slack. Off course everything is always logged.

### Headers
We have some nice headers which can improve the attack surface of your website. 
These headers could be set within your (NginX|Apache) config. But we can also set them in our application itself by means of a Request Middleware.  That’s exactly what this section does. 

#### Available headers
- Content-Security-Policy
- X-Frame-Options
- X-XSS-Options
- X-Content-Type-Options
- Referrer-Policy



### SecOps Check list


#### Available Checks
- App Secret-key set
- App running in debug-mode
- Using default admin-admin credentials
- Installed with dev-dependencies
- Using public mirrored directory
