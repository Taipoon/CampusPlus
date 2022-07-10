<?php

namespace App\Http\Controllers\BBS;

use App\Http\Controllers\Controller;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

  public function index()
  {
    // カテゴリ一覧表示画面
    // Eager Loading.
    $primary_categories = PrimaryCategory::with('secondary_categories')->get();

    return view('common.bbs.categories.index', compact('primary_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $secondary_categories = SecondaryCategory::findOrFail($id);
    return view('common.bbs.categories.show', compact('secondary_categories'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
