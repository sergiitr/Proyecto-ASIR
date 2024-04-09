<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat con Base de Datos Local</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="chat"> 
            <div class="chat-header">Chat</div>
            <div class="chat-window" id="chat-box">
                <ul class="message-list"></ul>
            </div>
            <div class="chat-input">
                <input type="text" class="message-input" id="user-input"  placeholder="Type your message here">
                <button class="send-button" onclick="sendMessage()">Send</button>
            </div>
        </div>
        <script>
            const chatBox = document.getElementById("chat-box");
            const userInput = document.getElementById("user-input");

            async function sendMessage() {
                const userMessage = userInput.value;
                if (userMessage.trim() !== "") {
                    appendMessage("Usuario", userMessage);
                    userInput.value = "";

                    // Manejar saludos y despedidas
                    if (isGreeting(userMessage)) {
                        appendMessage("IA", "¡Hola! ¿En qué puedo ayudarte?");
                        return;
                    } else if (isGoodbye(userMessage)) {
                        appendMessage("IA", "¡Hasta luego! ¡Que tengas un buen día!");
                        return;
                    }

                    // Manejar preguntas sobre videojuegos
                    const gameName = userMessage; // No es necesario extraer el nombre del juego
                    if (gameName) {
                        const gameAvailabilityResponse = await checkGameAvailability(gameName);
                        appendMessage("IA", gameAvailabilityResponse);
                    } else {
                        // Si no es una pregunta sobre videojuegos, usar la IA para obtener respuesta
                        const aiResponse = await getAIResponse(userMessage);
                        appendMessage("IA", aiResponse);
                    }
                }
            }

            async function getAIResponse(userMessage) {
                // Simular una respuesta de la IA
                return "Lo siento, no puedo determinar la disponibilidad del juego en este momento.";
            }

            async function checkGameAvailability(gameName) {
                try {
                    const response = await fetch("check_game_availability.php?gameName=" + encodeURIComponent(gameName));
                    const data = await response.json();
                    return data.message;
                } catch (error) {
                    console.error('Error al verificar la disponibilidad del juego:', error);
                    return "Lo siento, ha ocurrido un error al verificar la disponibilidad del juego.";
                }
            }

            function appendMessage(sender, message) {
                const messageElement = document.createElement("p");
                messageElement.textContent = `${sender}: ${message}`;
                chatBox.appendChild(messageElement);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            function isGreeting(message) {
                const greetings = ["hola", "hello", "hi", "hey"];
                return greetings.includes(message.toLowerCase());
            }

            function isGoodbye(message) {
                const goodbyes = ["adiós","adios", "bye", "hasta luego"];
                if (goodbyes.includes(message.toLowerCase())) {
                    setTimeout(clearChat, 3000); // Llama a la función clearChat() después de 3 segundos
                    return true;
                }
                return false;
            }

            function clearChat() {
                // Vacía el contenido del div que contiene la conversación
                chatBox.innerHTML = "";
            }
        </script>
    </body>
</html>