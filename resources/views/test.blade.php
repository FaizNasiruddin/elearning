<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chatbot Test</title>
</head>
<body>

<!-- Botpress Webchat V3 -->
<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>

<!-- In your <head> tag -->
<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<style>
  #webchat .bpWebchat {
    position: unset;
    width: 100%;
    height: 100%;
    max-height: 100%;
    max-width: 100%;
  }

  #webchat .bpFab {
    display: none;
  }
</style>

<!-- Put this on your page BEFORE the script below -->
<div id="webchat" style="width: 500px; height: 500px;"></div>

<!-- In your <body> tag -->
<script>
  // Generate a random user ID (or use a timestamp, or user ID from your system)
  const uniqueUserId = 'user_' + Date.now();

  window.botpress.on("webchat:ready", () => {
    window.botpress.open();
  });

  window.botpress.init({
    botId: "31ec012b-3685-4b49-94a5-1072b83cd95f",
    clientId: "fcc9b9f4-6883-4596-8d89-fc3ecbc4842b",
    selector: "#webchat",
    id: "my-webchat-embed999",
    userId: uniqueUserId, // ✅ This resets the chat for every load
    configuration: {
      website: {},
      email: {},
      phone: {},
      termsOfService: {},
      privacyPolicy: {}
    }
  });
</script>

</body>
</html>
