<!DOCTYPE html>
<html>
<head>
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, minimal-ui" />

    <style>
        /* Chrome, Safari and Opera syntax */
        :-webkit-full-screen {
            background-color: yellow;
        }

        /* Firefox syntax */
        :-moz-full-screen {
            background-color: yellow;
        }

        /* IE/Edge syntax */
        :-ms-fullscreen {
            background-color: yellow;
        }

        /* Standard syntax */
        :fullscreen {
            background-color: yellow;
        }

        /* Style the button */
        button {
            padding: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>

<h2>Fullscreen with JavaScript</h2>
<p>Click on the "Open Fullscreen" button to open this page in fullscreen mode. Close it by either clicking the "Esc" key on your keyboard, or with the "Close Fullscreen" button.</p>

<button onclick="openFullscreen();">Open Fullscreen</button>
<button onclick="closeFullscreen();">Close Fullscreen</button>

<script>
    var elem = document.documentElement;
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }
    }

    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
</script>

<p>Note: Internet Explorer 10 and earlier does not support fullscreen mode.</p>

</body>
</html>

