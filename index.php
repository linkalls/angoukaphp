<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>多文字置換暗号</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
    }
    
    #inputText, #outputText {
      color: #000000; /* light mode text color */
      background-color: #a2d9ff; /* light mode background color */
    }

    .max-w-md {
      background-color: #ffffff; /* light mode background color */
    }

    @media (prefers-color-scheme: dark) {
      body, #inputText, #outputText, .max-w-md {
        background-color: #1a202c;
        color: #d1d5db; /* light grey for dark mode text color */
      }
    }
  </style>
</head>

<body class="p-8">
  <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
    <h1 class="text-2xl font-semibold mb-4">多文字置換暗号</h1>
    <textarea id="inputText" class="w-full h-24 resize-none border border-gray-300 rounded-md p-2 mb-4"
      placeholder="テキストを入力してください..."></textarea>
    <div class="flex items-center mb-4">
      <input type="radio" id="encryptRadio" name="operation" value="encrypt" checked>
      <label for="encryptRadio" class="ml-2">暗号化</label>
      <input type="radio" id="decryptRadio" name="operation" value="decrypt" class="ml-4">
      <label for="decryptRadio" class="ml-2">復号化</label>
      <input type="checkbox" id="realtime" name="realtime" class="ml-4" checked>
      <label for="realtime" class="ml-2">リアルタイム変換</label>
    </div>
    <button onclick="convertText()"
      class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">変換</button>
    <textarea id="outputText" class="w-full h-24 resize-none border border-gray-300 rounded-md p-2 mt-4"
      placeholder="結果がここに表示されます..." readonly></textarea>
    <button onclick="copyToClipboard()"
      class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md mt-4">コピー</button>
    <p id="copyMessage" class="mt-2"></p>
  </div>

  <script>
    function convertText() {
      const inputText = document.getElementById('inputText').value;
      const operation = document.querySelector('input[name="operation"]:checked').value;

      // PHPスクリプトへ送信するデータを作成
      const formData = new FormData();
      formData.append('text', inputText);
      formData.append('operation', operation);

      // PHPスクリプトへ非同期でデータを送信
      fetch('cipher.php', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          document.getElementById('outputText').value = data;
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('outputText').value = '変換エラー';
        });
    }

    function copyToClipboard() {
      const outputText = document.getElementById('outputText');
      outputText.select();
      document.execCommand('copy');
      document.getElementById('copyMessage').textContent = 'コピーされました';
    }

    document.getElementById('inputText').addEventListener('input', function() {
      if (document.getElementById('realtime').checked) {
        convertText();
      }
    });

    document.getElementById('encryptRadio').addEventListener('change', function() {
      document.getElementById('outputText').value = '';
      if (document.getElementById('realtime').checked) {
        convertText();
      }
    });

    document.getElementById('decryptRadio').addEventListener('change', function() {
      document.getElementById('outputText').value = '';
      if (document.getElementById('realtime').checked) {
        convertText();
      }
    });
  </script>
</body>

</html>