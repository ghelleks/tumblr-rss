<?php

# go nuts.

function parse_post($post) {
  $type = $post->type;
  $link = $post->{'url-with-slug'};
  
  switch($type) {
    case 'regular':
      $title = $post->{"$type-title"};
      $description = $post->{"$type-body"};
      break;

    case 'link':
      $title = $post->{"$type-text"};
      $link = $post->{"$type-url"};
      $description = "{$post->{"$type-description"}}\n<p><a href=\"{$post->{'url-with-slug'}}\">#</a></p>";
      break;

    case 'quote':
      $title = trim($post->{"$type-source"});
      $description = "<blockquote>{$post->{"$type-text"}}</blockquote> <p>&mdash; {$post->{"$type-source"}}</p> ";
      break;

    case 'photo':
      # $title = $post->{"$type-caption"};
      # split caption into title and body, based on first newline.
      $body = ''; $title = '';
      list($title, $body) = explode("\n", $post->{"$type-caption"}, 2);
      #if (strlen($body) == 0) {
      #   $body = $title;
      #}

      $photo = "<img src=\"{$post->{"$type-url-1280"}}\" alt=\"" . strip_tags($title) ."\">";
      if (isset($post->{'photo-link-url'})) { $photo = "<a href=\"" . $post->{'photo-link-url'} . "\">$photo</a>"; }
        
      $description = "<p>$photo</p> {$body}";
      break;

    case 'conversation':
      $title = $post->{"$type-title"};
      $description = "<p>" . str_replace("\n", '<br>', $post->{"$type-text"}) . "</p>";
      break;

    case 'video':
      # split caption into title and body, based on first newline.
      $body = ''; $title = '';
      list($title, $body) = explode("\n", $post->{"$type-caption"}, 2);
      $description = "{$post->{"$type-player"}}\n{$body}";
      break;

    case 'audio':
      $title = "{$post->{'id3-artist'}} - {$post->{'id3-title'}}";
      $description = "{$post->{'audio-player'}}\n{$post->{"$type-caption"}}"; # Stick it in your ear, heredoc
      break;

    case 'answer':
      $title = "Question: {$post->{"$type-question"}}"; # P H P C E P T I O N
      $description = $post->{"$type-answer"};
      break;

    default:
      var_dump($post); die;
  }

  $title = trim(strip_tags($title));
  # if ($title == NULL || strlen($title) == 0) $title = ucfirst($type);
  
  return compact('title', 'description', 'link', 'type');
}
