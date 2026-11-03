<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Steganography Demo</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; background: #f4f4f9; color: #333; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #007BFF; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        textarea, input[type="file"] { width: 100%; margin-top: 5px; padding: 8px; box-sizing: border-box; }
        button { background: #007BFF; color: white; border: none; padding: 10px 15px; margin-top: 15px; cursor: pointer; border-radius: 4px; font-size: 16px; }
        button:hover { background: #0056b3; }
        pre { background: #eee; padding: 10px; border-radius: 4px; word-break: break-all; white-space: pre-wrap; }
        canvas { display: none; }
    </style>
</head>
<body>

    <h1>Image Steganography Tool</h1>
    <p>Hide secret text or QR data inside a cover image using browser pixel manipulation.</p>

    <!-- ENCODE SECTION -->
    <div class="card">
        <h2>1. Hide Data (Encoder)</h2>
        <label for="coverImage">Select Cover Image:</label>
        <input type="file" id="coverImage" accept="image/*">
        
        <label for="secretText">Secret Message / QR Data:</label>
        <textarea id="secretText" rows="3" placeholder="Enter secret text here..."></textarea>
        
        <button onclick="encodeMessage()">Hide Message & Download</button>
        <br><br>
        <a id="downloadLink" style="display:none;" download="stego_image.png">Download Stego Image</a>
    </div>

    <!-- DECODE SECTION -->
    <div class="card">
        <h2>2. Extract Data (Decoder)</h2>
        <label for="stegoImage">Select Stego Image:</label>
        <input type="file" id="stegoImage" accept="image/*">
        
        <button onclick="decodeMessage()">Extract Secret Message</button>
        
        <label>Extracted Result:</label>
        <pre id="outputResult">No message extracted yet.</pre>
    </div>

    <canvas id="canvas"></canvas>

    <script>
        // Helper: Convert text to binary string with termination marker
        function textToBinary(text) {
            const fullText = text + "###END###"; // Delimiter to signal end of message
            let binaryString = "";
            for (let i = 0; i < fullText.length; i++) {
                let bin = fullText.charCodeAt(i).toString(2).padStart(8, '0');
                binaryString += bin;
            }
            return binaryString;
        }

        // Helper: Convert binary string back to text
        function binaryToText(binary) {
            let text = "";
            for (let i = 0; i < binary.length; i += 8) {
                let byte = binary.slice(i, i + 8);
                if (byte.length < 8) break;
                let charCode = parseInt(byte, 2);
                text += String.fromCharCode(charCode);
                if (text.endsWith("###END###")) {
                    return text.replace("###END###", "");
                }
            }
            return "Error: Termination marker not found or image corrupted.";
        }

        function encodeMessage() {
            const fileInput = document.getElementById('coverImage');
            const secretText = document.getElementById('secretText').value;

            if (fileInput.files.length === 0 || !secretText) {
                alert("Please select an image and enter a secret message.");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.getElementById('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);

                    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const pixels = imgData.data;
                    const binary = textToBinary(secretText);

                    if (binary.length > pixels.length * 3 / 4) {
                        alert("Error: Message is too large for this image dimensions!");
                        return;
                    }

                    // Modify Least Significant Bits (LSB)
                    let dataIndex = 0;
                    for (let i = 0; i < pixels.length; i += 4) {
                        for (let channel = 0; channel < 3; channel++) { // R, G, B channels
                            if (dataIndex < binary.length) {
                                // Clear LSB and set it to the binary message bit
                                pixels[i + channel] = (pixels[i + channel] & ~1) | parseInt(binary[dataIndex]);
                                dataIndex++;
                            }
                        }
                    }

                    ctx.putImageData(imgData, 0, 0);

                    // Generate download link
                    const dataURL = canvas.toDataURL('image/png');
                    const downloadLink = document.getElementById('downloadLink');
                    downloadLink.href = dataURL;
                    downloadLink.style.display = 'block';
                    downloadLink.textContent = "Download Stego Image (.png)";
                    alert("Message successfully hidden! Click the download link below.");
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        }

        function decodeMessage() {
            const fileInput = document.getElementById('stegoImage');

            if (fileInput.files.length === 0) {
                alert("Please select a stego image to extract from.");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.getElementById('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);

                    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const pixels = imgData.data;

                    let binary = "";
                    for (let i = 0; i < pixels.length; i += 4) {
                        for (let channel = 0; channel < 3; channel++) {
                            binary += (pixels[i + channel] & 1).toString();
                        }
                    }

                    const extractedText = binaryToText(binary);
                    document.getElementById('outputResult').textContent = extractedText;
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    </script>
</body>
</html>