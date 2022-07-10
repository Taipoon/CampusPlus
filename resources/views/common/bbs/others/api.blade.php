@extends('layouts.others')

@section('title', 'Campus Plus API')

@php
$base_url = '/api';
@endphp

@section('content')
  <div class="mt-18 w-10/12 mx-auto">
    <h2 class="text-2xl font-semibold pb-2 border-b-2 border-gray-500 mb-1">API Documents</h2>
    {{-- ページ内リンク集 --}}
    <div class="py-4 px-4 mb-8 flex justify-around underline text-lg font-semibold">
      <a href="#searchThreads" class="inline-block mx-2">スレッド検索API</a>
      <a href="#searchComments" class="inline-block mx-2">コメント検索API</a>
      <a href="#getCategories" class="inline-block mx-2">カテゴリ取得API</a>
      <a href="#getThreadStatus" class="inline-block mx-2">ステータス取得API</a>
      <a href="#searchStudents" class="inline-block mx-2">学生検索API</a>
      <a href="#searchTeachers" class="inline-block mx-2">教職員検索API</a>
      <a href="#getFaculties" class="inline-block mx-2">学部取得API</a>
    </div>

    <div class="bg-red-200 font-bold py-4 px-4 mb-8 text-center">
      Campus Plus API をご利用の際は、会員登録後に<a href="{{ route('student.showToken', ['student' => Auth::id()]) }}"
        class="underline">こちら</a>から API
      アクセスキーを取得してください。
      <br>
      <br>
      すべてのAPIは、必ずパラメーターに key=APIアクセスキー を指定する必要があります。
      <p class="text-sm">※ APIの使用例ではアクセスキーのパラメーターは省略されています。</p>
    </div>

    {{-- スレッド検索API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500" id="searchThreads">スレッド検索API</h3>

    {{-- スレッド検索API 概要 --}}
    <div class="py-8">
      Campus Plus スレッド検索APIは、Campus Plus上で投稿されたスレッドをタイトル、
      スレッドステータス(※1)、投稿者ID、スレッド作成日、カテゴリなどで検索し、
      スレッド情報を取得することが可能(※2)なAPIです。
      <br>
      <p class="text-sm mt-2">(※1)スレッドタステータスとは、スレッドに設定される「回答募集中」、「解決済み」などの属性を指します。</p>
      <p class="text-sm mt-2">(※2)匿名スレッドは取得できません。匿名スレッドの閲覧・書き込みはCampus Plusをご利用ください。</p>
    </div>

    {{-- スレッド検索API 使い方 --}}
    <div class="py-2">
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/threads') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...</p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">タイトルに「プログラミング」を含み、スレッドステータスが「解決済み」のスレッド一覧を取得</p>
          <p>{{ url($base_url . '/threads') }}/?<span class="text-red-500">status=resolved&search=プログラミング</span></p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- スレッド検索API　入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center table-fixed">
        <thead class="table-header-group">
          <tr class="border-2">
            <th class="w-2/12">項目名</th>
            <th class="w-2/12">パラメーター</th>
            <th class="w-2/12">型</th>
            <th class="w-2/12">デフォルト</th>
            <th class="w-4/12">備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">スレッドID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">スレッドを一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">タイトル検索</td>
            <td class="border px-4 py-2">search</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値をタイトルに含むスレッドを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者ID</td>
            <td class="border px-4 py-2">userId</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">ユーザーを一意に識別するためのIDを用いて、当該ユーザーが投稿したスレッドのみを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">スレッドステータス</td>
            <td class="border px-4 py-2">status</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">"none", "required", "resolved" のいずれかを指定する。<br>
              none: 「指定なし」のみ。required: 「回答募集中」のみ。resolved: 「解決済み」のみ。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">第2カテゴリ</td>
            <td class="border px-4 py-2">category</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">カテゴリを一意に識別するためのIDを用いて、そのカテゴリが設定されたスレッドのみを取得。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日付以降</td>
            <td class="border px-4 py-2">afterDate</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd)を<b>含む</b>、それ以降に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日付以前</td>
            <td class="border px-4 py-2">beforeDate</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd)を<b>含まない</b>、それ以前に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日時以降</td>
            <td class="border px-4 py-2">afterDateTime</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd$H:m:s)を<b>含む</b>、それ以降に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日時以前</td>
            <td class="border px-4 py-2">beforeDateTime</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd$H:m:s)を<b>含まない</b>、それ以前に投稿されたコメントを取得する。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- スレッド検索API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">スレッドID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">スレッドを一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">タイトル</td>
            <td class="border px-4 py-2">title</td>
            <td class="border px-4 py-2">投稿されたスレッドのタイトル</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者ID</td>
            <td class="border px-4 py-2">user_id</td>
            <td class="border px-4 py-2">スレッドの投稿者を一意に識別するID。
              <a class="text-red-500" href="{{ route('api.students') }}" target="_blank">
                {{ url($base_url . '/students') }}</a> の [id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">ステータスID</td>
            <td class="border px-4 py-2">status_id</td>
            <td class="border px-4 py-2">スレッドのステータスを一意に識別するためのID。
              <a href="{{ route('api.status') }}" class="text-red-500"
                target="_blank">{{ url($base_url . '/status') }}</a>
              の [id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">ベストアンサーコメントID</td>
            <td class="border px-4 py-2">best_answer_comment_id</td>
            <td class="border px-4 py-2">スレッドステータスが「解決済み」であるスレッドで、ベストアンサーに設定されたコメントのID。スレッドステータスが「解決済み」でないスレッドは null
              が設定される。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">第2カテゴリID</td>
            <td class="border px-4 py-2">secondary_category_id</td>
            <td class="border px-4 py-2">スレッドに設定された第2カテゴリのID。
              <a href="{{ route('api.categories') }}" class="text-red-500"
                target="_blank">{{ url($base_url . '/categories') }}</a> の [secondary_categories.id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">作成日時</td>
            <td class="border px-4 py-2">created_at</td>
            <td class="border px-4 py-2">スレッドが作成された日時。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">コメント</td>
            <td class="border px-4 py-2">comments</td>
            <td class="border px-4 py-2">スレッドに投稿されたコメント一覧。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者情報</td>
            <td class="border px-4 py-2">student</td>
            <td class="border px-4 py-2">スレッドを投稿したユーザーの情報。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">カテゴリ情報</td>
            <td class="border px-4 py-2">secondary_category</td>
            <td class="border px-4 py-2">スレッドに設定された第2カテゴリ、第1カテゴリの情報。</td>
          </tr>
        </tbody>
      </table>

    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="searchComments">

    {{-- コメント検索API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">コメント検索API</h3>

    {{-- コメント検索API 概要 --}}
    <div class="py-8">
      Campus Plus コメント検索APIは、Campus Plus上で投稿されたコメントを、
      スレッドタイプ(※1)、投稿者ID、スレッド作成日、カテゴリなどで検索し、
      スレッド情報を取得することが可能なAPIです。
      <br>
      <p class="text-sm mt-2">(※1)スレッドタイプとは、スレッド作成時に設定された「回答募集中」、「解決済み」などの属性を指します。</p>
    </div>

    {{-- コメント検索API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- コメント検索API リクエストURLとその例 --}}

      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/comments') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...
      </p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">テキストに「開志」を含み、2022年2月10日13時10分以降に投稿されたコメントを取得する。</p>
          <p>{{ url($base_url . '/comments') }}/?<span
              class="text-red-500">search=開志&afterDateTime=2022-2-10$13:10</span>
          </p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- コメント検索API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>型</th>
            <th>デフォルト</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">コメントID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">コメントを一意に識別するためのID</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者ID</td>
            <td class="border px-4 py-2">userId</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">コメントの投稿者を一意に識別するID。
              <a class="text-red-500" href="{{ route('api.students') }}" target="_blank">
                {{ url($base_url . '/students') }}</a> の [id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">返信先コメントID</td>
            <td class="border px-4 py-2">replyTo</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">返信先のコメントID。返信先が存在しない場合は null が設定されている。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">テキスト検索</td>
            <td class="border px-4 py-2">search</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">コメントにパラメーターで指定した値を含むコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日付以降</td>
            <td class="border px-4 py-2">afterDate</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd)を<b>含む</b>、それ以降に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日付以前</td>
            <td class="border px-4 py-2">beforeDate</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd)を<b>含まない</b>、それ以前に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日時以降</td>
            <td class="border px-4 py-2">afterDateTime</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd$H:m:s)を<b>含む</b>、それ以降に投稿されたコメントを取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">日時以前</td>
            <td class="border px-4 py-2">beforeDateTime</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値 (形式: YYYY-mm-dd$H:m:s)を<b>含まない</b>、それ以前に投稿されたコメントを取得する。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- コメント検索API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">コメントID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">コメントを一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">テキスト</td>
            <td class="border px-4 py-2">text</td>
            <td class="border px-4 py-2">投稿されたコメントのテキスト。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者ID</td>
            <td class="border px-4 py-2">user_id</td>
            <td class="border px-4 py-2">コメントの投稿者を一意に識別するID。
              <a class="text-red-500" href="{{ route('api.students') }}" target="_blank">
                {{ url($base_url . '/students') }}</a> の [id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">スレッドID</td>
            <td class="border px-4 py-2">thread_id</td>
            <td class="border px-4 py-2">コメントがどのスレッドに投稿されたのかを示すID。
              <a href="{{ route('api.threads') }}" class="text-red-500"
                target="_blank">{{ url($base_url . '/threads') }}</a> の [id] に対応する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">返信先コメントID</td>
            <td class="border px-4 py-2">reply_to</td>
            <td class="border px-4 py-2">返信先のコメントID。返信先が存在しない場合は null が設定されている。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿日時</td>
            <td class="border px-4 py-2">created_at</td>
            <td class="border px-4 py-2">コメントが投稿された日時を表す。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">投稿者情報</td>
            <td class="border px-4 py-2">student</td>
            <td class="border px-4 py-2">投稿者の詳細な情報を表す。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">スレッド情報</td>
            <td class="border px-4 py-2">thread</td>
            <td class="border px-4 py-2">スレッドの詳細な情報を表す。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="getCategories">

    {{-- カテゴリ取得API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">カテゴリ取得API</h3>

    {{-- カテゴリ取得API 概要 --}}
    <div class="py-8">
      Campus Plus カテゴリ取得APIは、スレッドを分類するために設定される、カテゴリを一覧で取得することが可能なAPIです。
      <br>
      {{-- <p class="text-sm mt-2">(※1)スレッドタイプとは、スレッド作成時に設定された「回答募集中」、「解決済み」などの属性を指します。</p> --}}
    </div>

    {{-- カテゴリ取得API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- カテゴリ取得API リクエストURLとその例 --}}
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/categories') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...
      </p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">第1カテゴリIDが3であるカテゴリを取得する。</p>
          <p>{{ url($base_url . '/comments') }}?<span class="text-red-500">id=3</span>
          </p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- コメント検索API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>型</th>
            <th>デフォルト</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">カテゴリID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">第1カテゴリを一意に識別するためのID。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- コメント検索API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">第1カテゴリID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">第1カテゴリを一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">カテゴリ名</td>
            <td class="border px-4 py-2">name</td>
            <td class="border px-4 py-2">カテゴリの名前。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">第2カテゴリ</td>
            <td class="border px-4 py-2">secondary_categories</td>
            <td class="border px-4 py-2">第1カテゴリに所属するすべての第2カテゴリ。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="getThreadStatus">

    {{-- スレッドステータス取得API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">スレッドステータス取得API</h3>

    {{-- スレッドステータス取得API 概要 --}}
    <div class="py-8">
      Campus Plus スレッドステータス取得API は、スレッドに設定されるスレッドステータスの一覧を取得できるAPIです。
    </div>

    {{-- スレッドステータス取得API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- スレッドステータス取得API リクエストURLとその例 --}}
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">{{ url($base_url . '/status') }}?key=[YOUR_API_ACCESS_KEY]
      </p>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学部取得API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      入力パラーメーターはありません。

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学部取得API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">ステータスID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">スレッドステータスを一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">項目名</td>
            <td class="border px-4 py-2">name</td>
            <td class="border px-4 py-2">スレッドの状態を示す項目名。</td>
          </tr>
        </tbody>
      </table>
      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="searchStudents">

    {{-- 学生検索API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">学生検索API</h3>

    {{-- 学生検索API 概要 --}}
    <div class="py-8">
      Campus Plus 学生検索API は、Campus Plusに登録している学生を、ID、学籍番号、学部などで検索が可能なAPIです。
    </div>

    {{-- 学生検索API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- 学生検索API リクエストURLとその例 --}}
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/students') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...
      </p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">情報学部で苗字が「平山」である学生を検索する。</p>
          <p>{{ url($base_url . '/students') }}?<span class="text-red-500">faculty=ict&lastName=平山</span>
          </p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学生検索API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>型</th>
            <th>デフォルト</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">ユーザーID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">学生を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">学籍番号</td>
            <td class="border px-4 py-2">number</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値を含む学籍番号を持つ学生を取得する。<br>number=2012 と指定すると2012を学籍番号に含むすべての学生を取得する。
            </td>
          </tr>
          <tr>
            <td class="border px-4 py-2">姓</td>
            <td class="border px-4 py-2">lastName</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">苗字にパラメーターで指定した値を含む学生を取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">名</td>
            <td class="border px-4 py-2">firstName</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">名前にパラメーターで指定した値を含む学生を取得する。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">学部学科</td>
            <td class="border px-4 py-2">faculty</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2"> "ict" または "business" または "anime" を指定する。<br>
              ict: 情報学部、business: 事業創造学部、anime: アニメ・マンガ学部を表す。
            </td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学生検索API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">ユーザーID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">学生を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">姓</td>
            <td class="border px-4 py-2">last_name</td>
            <td class="border px-4 py-2">学生の苗字。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">名</td>
            <td class="border px-4 py-2">first_name</td>
            <td class="border px-4 py-2">学生の名前。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">セイ</td>
            <td class="border px-4 py-2">last_name_kana</td>
            <td class="border px-4 py-2">学生の苗字のカナ表記。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">メイ</td>
            <td class="border px-4 py-2">first_name_kana</td>
            <td class="border px-4 py-2">学生の名前のカナ表記。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">メールアドレス</td>
            <td class="border px-4 py-2">email</td>
            <td class="border px-4 py-2">学生の登録メールアドレス。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">学部ID</td>
            <td class="border px-4 py-2">faculty_id</td>
            <td class="border px-4 py-2">学部を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">プロフィール</td>
            <td class="border px-4 py-2">profile</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したプロフィール。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">Twitter</td>
            <td class="border px-4 py-2">twitter</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したTwitter URL。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">Instagram</td>
            <td class="border px-4 py-2">instagram</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したInstagram URL。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">GitHub</td>
            <td class="border px-4 py-2">github</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したGitHub URL。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">YouTube</td>
            <td class="border px-4 py-2">youtube</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したYoutube URL。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">URL</td>
            <td class="border px-4 py-2">url</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定したURL。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">Information</td>
            <td class="border px-4 py-2">information</td>
            <td class="border px-4 py-2">学生がCampus Plus上で設定した備考。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="searchTeachers">

    {{-- 教職員検索API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">教職員検索API</h3>

    {{-- 教職員検索API 概要 --}}
    <div class="py-8">
      Campus Plus 教職員検索API は、Campus Plusに登録している教職員を、ID、氏名で検索が可能なAPIです。
    </div>

    {{-- 教職員検索API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- 教職員検索API リクエストURLとその例 --}}
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/teachers') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...
      </p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">名前に「情報」を含む教職員を検索する。</p>
          <p>{{ url($base_url . '/teachers') }}?<span class="text-red-500">name=情報</span>
          </p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 教職員検索API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>型</th>
            <th>デフォルト</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">ユーザーID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">教職員を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">氏名</td>
            <td class="border px-4 py-2">name</td>
            <td class="border px-4 py-2">string</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">パラメーターで指定した値を含む名前の教職員を取得する。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 教職員検索API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">ユーザーID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">教職員を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">氏名</td>
            <td class="border px-4 py-2">name</td>
            <td class="border px-4 py-2">教職員の氏名。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">メールアドレス</td>
            <td class="border px-4 py-2">email</td>
            <td class="border px-4 py-2">教職員の登録メールアドレス。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

    <hr class="border-b-2 border-gray-50 mt-4 mb-8" id="getFaculties">

    {{-- 学部取得API --}}
    <h3 class="text-xl font-semibold border-b border-gray-500 mt-12">学部取得API</h3>

    {{-- 学部取得API 概要 --}}
    <div class="py-8">
      Campus Plus 学部取得API は、学部IDや学部名などの可能なAPIです。
    </div>

    {{-- 学部取得API 使い方 --}}
    <div class="py-2" id="request-url-1">

      {{-- 学部取得API リクエストURLとその例 --}}
      <h4 class="text-lg font-bold mb-2">リクエストURL</h4>
      <p class="py-2 px-8 bg-base font-semibold text-black">
        {{ url($base_url . '/faculties') }}?key=[YOUR_API_ACCESS_KEY]&[parameter]=[value]...
      </p>
      <div>
        <p>(例)</p>
        <div>
          <p class="font-semibold">学部IDが2である学部を取得する。</p>
          <p>{{ url($base_url . '/faculties') }}?<span class="text-red-500">id=2</span>
          </p>
        </div>
      </div>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学部取得API 入力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">入力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>型</th>
            <th>デフォルト</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">学部ID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">int</td>
            <td class="border px-4 py-2">-</td>
            <td class="border px-4 py-2">学部を一意に識別するためのID。</td>
          </tr>
        </tbody>
      </table>

      <hr class="border-b-2 border-gray-50 mt-4 mb-8">

      {{-- 学部取得API 出力パラメーター --}}
      <h4 class="text-lg font-bold mb-2">出力パラメーター</h4>
      <table class="w-full text-center">
        <thead class="table-header-group">
          <tr class="border-2">
            <th>項目名</th>
            <th>パラメーター</th>
            <th>備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">学部ID</td>
            <td class="border px-4 py-2">id</td>
            <td class="border px-4 py-2">学部を一意に識別するためのID。</td>
          </tr>
          <tr>
            <td class="border px-4 py-2">学部名</td>
            <td class="border px-4 py-2">faculty_name</td>
            <td class="border px-4 py-2">学部の名前。</td>
          </tr>
        </tbody>
      </table>
      <hr class="border-b-2 border-gray-50 mt-4 mb-8">
    </div>

  </div>

@endsection
