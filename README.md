# OpenCartCustomSocialNetworkPlugin (OpenCart 3)
Social media plugin for opencart is a lightweight, simple and customizable plugin for OpenCart 3. You can add more social media link setting easily and use this plugin with your custom template design. 


## Getting Start
### Prerequisites
What things you need to install the software and how to install them. 

1. OpenCart 3 (Download from following link)
```
https://www.opencart.com/index.php?route=cms/download
```
2. Download this plugin from GitHub
3. Extract admin and catalog folder to your opencart root installation folder.
### How to use ?
1. You can find setting option of social network on 
```
Admin panel > Extensions > Extensions > Modules > Social Network
```
At first enable this plugin and then edit your required social media links
2. Then find example folder and check following file to know how you can send social media links to your header view
```
Catalog > controller > common > header.php
```
3. Then find simple code to add a simple/basic social link on following file
```
Catalog > view > theme > default > template > common > header.twig
```
N.B: Please don't copy and paste above mentioned file to your real header.twig file. This twig file is an example to retrive social media link. For testing, copy the code of this file and paste is to your real header.twig file where you want to place social link.
