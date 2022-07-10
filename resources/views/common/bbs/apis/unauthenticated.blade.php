<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>認証されていません。</title>
</head>

<body>
  <h1>401 Unauthorized.</h1>

  <h2>認証されたユーザーのみが Campus Plus API を利用できます。</h2>
  <p>
    Campus Plus にログイン後、API Token を取得し、URLパラメーターでトークンを指定してください。<br>
  </p>
  <div class="bg-gray-300 text-semibold">
    <h4>例</h4>
    <b>{{ url('/api/threads') }}?key=[YOUR_API_TOKEN]</b>
  </div>
  <br>

</body>

</html>
