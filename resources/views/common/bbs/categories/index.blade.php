カテゴリ一覧ページ
<ul>
  @foreach ($primary_categories as $primary_category)

    <li>{{ $primary_category->name }}
      <ul>
        @foreach ($primary_category->secondary_categories as $secondary_category)
          <a href="{{ route('student.threads.categories.show', ['category' => $secondary_category->id]) }}">
            <li>{{ $secondary_category->name }}</li>
          </a>
        @endforeach
      </ul>
    </li>
  @endforeach
</ul>
