function showLoginMessage(message2) {
    const messageElement = document.getElementById("login-message");
    messageElement.textContent = message2;
    messageElement.classList.add("show");
  
    // Set timeout to hide the message automatically
    setTimeout(function() {
      messageElement.classList.remove("show");
    }, 3000); // Adjust timeout (in milliseconds)
  }
  