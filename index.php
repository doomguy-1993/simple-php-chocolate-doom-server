<?php

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

// --- NO NEED TO EDIT ANYTHING BELOW THIS LINE --- //

$action = $_POST['action'] ?? false;
$form_action = filter_var(SERVER_SCHEME . '://' . SERVER_HOST . SERVER_DOOM_URI, FILTER_SANITIZE_URL);

function getPids() {
    exec("pgrep chocolate-doom", $pids);
    return $pids;
}
function isRunning() {
    exec("pgrep chocolate-doom", $pids);
    return ! empty($pids);
}
function stop() {
    if (isRunning()) { 
        foreach (getPids() as $pid) {
            exec('kill ' . (int) $pid);
        }  
    }
    header("Refresh:0");
}
function start() {
    if (! isRunning()) {
        $flag_private = (PRIVATE_SERVER === true) ? ' -privateserver' : '';
        $command = realpath(CHOCOLATE_EXECUTABLE) . ' -dedicated' . $flag_private. ' >/dev/null 2>/dev/null &';
        exec($command);
    }
    header("Refresh:0");
}
function esc($str) {
    return htmlentities($str, ENT_QUOTES);
}

if ($action && $action === 'stop') {
    stop();
} else if ($action && $action === 'start') {
    start();
}

if ($_GET['refresh'] == 1) {
    header("Refresh:0");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple PHP Chocolate Doom Server</title>
    <style>
        body {
            background: #000;
            color: #FFF;
            text-align: center;
            font-family: Consolas,monaco,monospace; 
            font-size: 16px;
            line-height: 2;
        }
        h1 {
            color: #FFF;
            font-size: 30px;
            margin-top: 30px;
        }
        h2 {
            font-size: 18px;
        }
        p {
            margin: 40px;
        }
        code {
            border: 1px dotted #CCC;
            padding: 5px;
        }
        hr {
            margin: 20px 0;
        }
        .img-container {
            height: 170px;
        }
        button.large {
            font-size: 20px;
        }
        button.link {
            border: none;
            background: none;
            color: #FFF;
            border-bottom: 1px solid #FFF;
        }
        button.link {
            color: #EEE;
        }
    </style>
</head>
<body>
    
    <form action="<?php echo $form_action ?>?refresh=1" method="GET">
        <button type="submit" class="link">Click to refresh</button>
    </form>

    <form action="<?php echo $form_action ?>" method="POST">
        <?php if (isRunning()): ?>
            <h1 style="color:#3cb371">DOOM IS RUNNING!<h1>
            <input type="hidden" name="action" value="stop">
            <button type="submit" class="large">STOP SERVER</button>
        <?php else: ?>
            <h1 style="color:#ff0000">DOOM IS NOT RUNNING<h1>
            <input type="hidden" name="action" value="start">
            <button type="submit" class="large">START SERVER</button>
        <?php endif; ?>
    </form>

    <?php if (isRunning()): ?>
        <hr>
        
        <h2>Select game parameters</h2>

        <div id="options">
            <select name="game" id="game">
                <option value="doom">Doom / Ultimate Doom</option>
                <option value="doom2">Doom II</option>
            </select>

            <select name="level-doom1" id="level-doom1">
                <optgroup label="Knee-Deep in the Dead">
                    <option value="1 1">E1M1: Hangar</option>
                    <option value="1 2">E1M2: Nuclear Plant</option>
                    <option value="1 3">E1M3: Toxin Refinery</option>
                    <option value="1 4">E1M4: Command Control</option>
                    <option value="1 5">E1M5: Phobos Lab</option>
                    <option value="1 6">E1M6: Central Processing</option>
                    <option value="1 7">E1M7: Computer Station</option>
                    <option value="1 8">E1M8: Phobos Anomaly </option>
                    <option value="1 9">E1M9: Military Base</option>
                </optgroup>
                <optgroup label="The Shores of Hell">
                    <option value="2 1">E2M1: Deimos Anomaly</option>
                    <option value="2 2">E2M2: Containment Area</option>
                    <option value="2 3">E2M3: Refinery</option>
                    <option value="2 4">E2M4: Deimos Lab</option>
                    <option value="2 5">E2M5: Command Center</option>
                    <option value="2 6">E2M6: Halls of the Damned</option>
                    <option value="2 7">E2M7: Spawning Vats</option>
                    <option value="2 8">E2M8: Tower of Babel</option>
                    <option value="2 9">E2M9: Fortress of Mystery</option>
                </optgroup>
                <optgroup label="Inferno">
                    <option value="3 1">E3M1: Hell Keep</option>
                    <option value="3 2">E3M2: Slough of Despair</option>
                    <option value="3 3">E3M3: Pandemonium</option>
                    <option value="3 4">E3M4: House of Pain</option>
                    <option value="3 5">E3M5: Unholy Cathedral</option>
                    <option value="3 6">E3M6: Mt. Erebus</option>
                    <option value="3 7">E3M7: Limbo</option>
                    <option value="3 8">E3M8: Dis</option>
                    <option value="3 9">E3M9: Warrens</option>
                </optgroup>
                <optgroup label="Thy Flesh Consumed">
                    <option value="4 1">E4M1: Hell Beneath</option>
                    <option value="4 2">E4M2: Perfect Hatred</option>
                    <option value="4 3">E4M3: Sever the Wicked</option>
                    <option value="4 4">E4M4: Unruly Evil</option>
                    <option value="4 5">E4M5: They Will Repent</option>
                    <option value="4 6">E4M6: Against Thee Wickedly</option>
                    <option value="4 7">E4M7: And Hell Followed</option>
                    <option value="4 8">E4M8: Unto the Cruel</option>
                    <option value="4 9">E4M9: Fear</option>
                </optgroup>
            </select>
            <select name="level-doom2" id="level-doom2" style="display: none;">
                <optgroup label="The Space Station">
                    <option value="1">Level 1: Entryway</option>
                    <option value="2">Level 2: Underhalls</option>
                    <option value="3">Level 3: The Gantlet</option>
                    <option value="4">Level 4: The Focus</option>
                    <option value="5">Level 5: The Waste Tunnels</option>
                    <option value="6">Level 6: The Crusher</option>
                    <option value="7">Level 7: Dead Simple</option>
                    <option value="8">Level 8: Tricks and Traps</option>
                    <option value="9">Level 9: The Pit</option>
                    <option value="10">Level 10: Refueling Base</option>
                    <option value="11">Level 11: 'O' of Destruction! / Circle of Death</option>
                </optgroup>
                <optgroup label="The City">
                    <option value="12">Level 12: The Factory</option>
                    <option value="13">Level 13: Downtown</option>
                    <option value="14">Level 14: The Inmost Dens</option>
                    <option value="15">Level 15: Industrial Zone </option>
                    <option value="16">Level 16: Suburbs</option>
                    <option value="17">Level 17: Tenements</option>
                    <option value="18">Level 18: The Courtyard</option>
                    <option value="19">Level 19: The Citadel</option>
                    <option value="20">Level 20: Gotcha!</option>
                </optgroup>
                <optgroup label="Hell">
                    <option value="21">Level 21: Nirvana</option>
                    <option value="22">Level 22: The Catacombs</option>
                    <option value="23">Level 23: Barrels o' Fun</option>
                    <option value="24">Level 24: The Chasm</option>
                    <option value="25">Level 25: Bloodfalls</option>
                    <option value="26">Level 26: The Abandoned Mines</option>
                    <option value="27">Level 27: Monster Condo</option>
                    <option value="28">Level 28: The Spirit World</option>
                    <option value="29">Level 29: The Living End</option>
                    <option value="30">Level 30: Icon of Sin</option>
                </optgroup>
                <optgroup label="Secret levels">
                    <option value="31">Level 31: Wolfenstein</option>
                    <option value="32">Level 32: Grosse</option>
                </optgroup>
            </select>
            <select name="game-type" id="game-type">
                <option value="coop">Co-Op</option>
                <option value="dm">Deathmatch</option>
            </select>
            <select name="monsters" id="monsters">
                <option value="mo">Monsters On</option>
                <option value="nomo">Monsters Off</option>
            </select>
            <select name="skill" id="skill">
                <option value="1">I'm too young to die</option>
                <option value="2">Hey, not too rough</option>
                <option value="3">Hurt me plenty</option>
                <option value="4">Ultra-Violence</option>
                <option value="5">Nightmare!</option>
            </select>
        </div>

        <hr>
        <p>First player to connect specifies the game parameters:</p>
        <code>
            chocolate-doom -connect <span class="host"><?php echo esc(SERVER_HOST) ?></span> <span id="warp">-warp E M</span><span id="flag-game-type"></span><span id="flag-monsters"></span><span id="flag-skill"></span> -iwad /path/to/wad
        </code>
        <br>
        <p>Other players run:</p>
        <code>chocolate-doom -connect <span class="host"><?php echo esc(SERVER_HOST) ?></span> -wad /path/to/wad</code>

        <script>
            function setLevel(level) {
                document.getElementById("warp").innerText = "-warp " + level;
            }
            function setGame(game) {
                if (game === 'doom2') {
                    doom1LevelElement.style.display = 'none';
                    doom2LevelElement.style.display = 'inline-block';
                    level = doom2LevelElement.value;
                } else if (game === 'doom') {
                    doom1LevelElement.style.display = 'inline-block';
                    doom2LevelElement.style.display = 'none';
                    level = doom1LevelElement.value;
                }
                setLevel(level);
            }
            function setGameType(gametype) {
                if (gametype === 'dm') {
                    document.getElementById("flag-game-type").innerText = ' -deathmatch';
                } else {
                    document.getElementById("flag-game-type").innerText = '';
                }
            }
            function setMonsters(monsters) {
                if (monsters === 'nomo') {
                    document.getElementById("flag-monsters").innerText = ' -nomonsters';
                } else {
                    document.getElementById("flag-monsters").innerText = '';
                }
            }
            function setSkill(skill) {
                let skillflag = ' -skill ' + skill;
                document.getElementById("flag-skill").innerText = skillflag;
            }

            const gameElement       =   document.getElementById("game");
            const doom1LevelElement =   document.getElementById("level-doom1");
            const doom2LevelElement =   document.getElementById("level-doom2");
            const gameTypeElement   =   document.getElementById("game-type");
            const monstersElement   =   document.getElementById("monsters");
            const skillElement      =   document.getElementById("skill");

            gameElement.addEventListener("change", (event) => {
                setGame(event.target.value);
            });
            doom1LevelElement.addEventListener("change", (event) => {
                setLevel(event.target.value);
            });
            doom2LevelElement.addEventListener("change", (event) => {
                setLevel(event.target.value);
            });
            gameTypeElement.addEventListener("change", (event) => {
                setGameType(event.target.value);
            });
            monstersElement.addEventListener("change", (event) => {
                setMonsters(event.target.value);
            });
            skillElement.addEventListener("change", (event) => {
                setSkill(event.target.value);
            });

            setGame(gameElement.value);
            setGameType(gameTypeElement.value);
            setMonsters(monstersElement.value);
            setSkill(skillElement.value);
        </script>
    <?php endif; ?>
</body>
</html>