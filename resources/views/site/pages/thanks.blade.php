<html>
<head>
</head>
<body>
<script>
function inIframe () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

if (inIframe()) {
    window.top.postMessage('close', '*');
}
window.close();
</script>
</body>
</html>