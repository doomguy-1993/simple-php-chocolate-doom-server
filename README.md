# Simple PHP Chocolate Doom Server

A simple web page to start and stop a dedicated Chocolate Doom server, conveniently put in a single PHP file. Feel free to deploy it on your own server for your Chocolate Doom multiplayer session needs!

Features:

- A big button to start and stop the Chocolate Doom server
- A simple user interface to generate the game parameters for joining the game.

![Screenshot](screenshot.png?raw=true "Screenshot")

## Setup

To use this script, you need a Linux server capable of serving PHP pages. The script has been tested to work on Ubuntu 20.04.5 LTS running PHP 7.4.3 (though other distros will probably work too).

Edit the following constants in index.php to match your own configuration (using a plain-text editor):

```
// The full path to your chocolate-doom executable
// Example: /usr/games/chocolate-doom
const CHOCOLATE_EXECUTABLE = '/usr/games/chocolate-doom';

// The URL scheme for your site
// Example: https or http
const SERVER_SCHEME = 'https';

// The host where your server is running
// Example: example.com or 192.168.0.1
const SERVER_HOST = 'your-site-here.tld';

// The URI to this file.
// Example: /mydoomdir/index.php
const SERVER_DOOM_URI = '/your-doom-dir/index.php';

// When this is set to true, your server will not be registered 
// with the master server at https://master.chocolate-doom.org/
const PRIVATE_SERVER = true;
```

## Important

- The script does not install Chocolate Doom on your server for you. See the Chocolate Doom website for instructions on how to download and install Chocolate Doom: https://www.chocolate-doom.org

- Chocolate Doom servers run on UDP port 2342, meaning that this port needs to be accessible by connecting clients

- The page has no authentication or other security built-in. It is your own responsibility to make sure it can only be accessed by authorized people, for example, by putting it behind authentication, firewall restrictions, or at the very least, using a loooooong hard-to-guess filename.

- This project is not affiliated with the Chocolate Doom source port project or its creators and it comes with absolutely no warranties. Use it at your own risk!


## More technical stuff (for those interested)

- The script uses PHP's exec function to start and stop chocolate-doom, meaning that exec has to be enabled for it to work (note that exec can be a potentially dangerous function if used incorrectly).
- The script uses pgrep to find chocolate-doom processes to kill in order to stop the server
- JavaScript needs to be enabled in your browser to use the game parameters generator (starting and stopping the server will still work even without JavaScript)
