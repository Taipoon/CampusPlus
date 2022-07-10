<?php

namespace App\Constants;

class CommonConstants
{
  // faculties テーブルを参照すること
  public const ICT = 1;
  public const BUSINESS = 2;
  public const ANIME = 3;

  public const FACULTY_CODE = [
    'ict' => self::ICT,
    'business' => self::BUSINESS,
    'anime' => self::ANIME,
  ];

  // thread_status テーブルを参照すること
  public const NOT_SPECIFIED = 1;
  public const REQUEST_FOR_ANSWER = 2;
  public const RESOLVED = 3;

  public const STATUS_CODE = [
    'none' => self::NOT_SPECIFIED,
    'required' => self::REQUEST_FOR_ANSWER,
    'resolved' => self::RESOLVED,
  ];

  // primary_categories, secondary_categories テーブルを参照すること
  public const CATEGORIES = [
    '雑談' => [
      '一般',
      '占い・ゴシップ',
      '趣味・ゲーム',
      'オススメ書籍・記事',
      '写真・動画を投稿する',
      'システム開発・ゲーム作り',
    ],
    '大学' => [
      '大学への要望・意見',
      '専律会・学園祭',
      'クラブ・サークル',
      'プログラミングコンテスト',
      '就職活動・インターン',
    ],
    '課題・宿題' => [
      '質問一般',
      '勉強仲間募集',
      '個人メモ',
    ],
    '講義内容について' => [
      'OS・DB・ネットワーク全般',
      'プログラミング全般・データ構造とアルゴリズム',
      '線形代数・微分積分・確率論・統計学',
      '消費者行動・マーケティング・情報と経営',
      '知識表現知識処理・AI実習・データサイエンス実習・情報科学基礎',
      'サイバーセキュリティ全般',
      '日本語/英語コミュニケーション',
      '情報リテラシー・情報産業論・情報と法律',
      '没入型コンピューティング',
      'デザイン・シンキング全般',
      'コンピュータアーキテクチャ・IoT・CPS',
      'キャリアデザイン・現代社会学・ソーシャルデザイン',
    ],
  ];

  /* Model Factory 最大生成数 */

  // 学生数
  public const MAX_STUDENTS = 30;
  // スレッド数
  public const MAX_THREADS = 50;
  // コメント数
  public const MAX_COMMENTS = 200;

  /* コメントの最大文字数 */
  public const MAX_THREAD_TITLE = 40;
  public const MAX_COMMENT_CONTENTS = 700;

  // マルチバイト(全角スペース等)対応のトリミング処理
  public static function mbTrim($pString)
  {
    return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $pString);
  }

  // 指定した文字数以上の文章は語尾に ... をつけて省略表記にする
  public static function getOmittedText($text, $limit = 20)
  {
    if (mb_strlen($text) > $limit) {
      $omitted_text = mb_substr($text, 0, $limit);
      $text = $omitted_text . '...';
    }
    return $text;
  }

  // 通知タイプ
  public const NOTIFICATION_TYPES = [
    'good_comment' => 1,
    'good_thread' => 2,
    'reply' => 3,
    'direct_message' => 4,
  ];
}
