{extends "layout.tpl"}

{block "content"}
    <h1>{$user->username}</h1>
    <p>{Route::url('user', [ 'action' => 'register' ], true)}{URL::query([ 'ref' => $user->id ])}</p>
{/block}