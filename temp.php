/**
 * Parses a piece of user-entered text to match user mentions
 * and replace with a link and avatar.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseUsersAndAvatars($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\B%([A-Za-z0-9_-]+)/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $user = App\Models\User\User::where('name', $match)->first();
            if ($user) {
                $users[] = $user;
                $text = preg_replace('/\B%'.$match.'/', '<a href="'.$user->url.'"><img src="'.$user->avatarUrl.'" style="width:70px; height:70px; border-radius:50%; " alt="'.$user->name.'\'s Avatar"></a>'.$user->displayName, $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match userid mentions
 * and replace with a link.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseUserIDs($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\[user=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $user = App\Models\User\User::where('id', $match)->first();
            if ($user) {
                $users[] = $user;
                $text = preg_replace('/\[user='.$match.'\]/', $user->displayName, $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match userid mentions
 * and replace with a user avatar.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseUserIDsForAvatars($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\[userav=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $user = App\Models\User\User::where('id', $match)->first();
            if ($user) {
                $users[] = $user;
                $text = preg_replace('/\[userav='.$match.'\]/', '<a href="'.$user->url.'"><img src="'.$user->avatarUrl.'" style="width:70px; height:70px; border-radius:50%; " alt="'.$user->name.'\'s Avatar"></a>', $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match character mentions
 * and replace with a link.
 *
 * @param string $text
 * @param mixed  $characters
 *
 * @return string
 */
function parseCharacters($text, &$characters) {
    $matches = null;
    $characters = [];
    $count = preg_match_all('/\[character=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $character = App\Models\Character\Character::where('slug', $match)->first();
            if ($character) {
                $characters[] = $character;
                $text = preg_replace('/\[character='.$match.'\]/', $character->displayName, $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match character mentions
 * and replace with a thumbnail.
 *
 * @param string $text
 * @param mixed  $characters
 *
 * @return string
 */
function parseCharacterThumbs($text, &$characters) {
    $matches = null;
    $characters = [];
    $count = preg_match_all('/\[charthumb=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $character = App\Models\Character\Character::where('slug', $match)->first();
            if ($character) {
                $characters[] = $character;
                $text = preg_replace('/\[charthumb='.$match.'\]/', '<a href="'.$character->url.'"><img class="img-thumbnail" alt="Thumbnail of '.$character->fullName.'" data-toggle="tooltip" title="'.$character->fullName.'" src="'.$character->image->thumbnailUrl.'"></a>', $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match gallery submission thumb mentions
 * and replace with a link.
 *
 * @param string $text
 * @param mixed  $submissions
 *
 * @return string
 */
function parseGalleryThumbs($text, &$submissions) {
    $matches = null;
    $submissions = [];
    $count = preg_match_all('/\[thumb=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $submission = App\Models\Gallery\GallerySubmission::where('id', $match)->first();
            if ($submission) {
                $submissions[] = $submission;
                $text = preg_replace('/\[thumb='.$match.'\]/', '<a href="'.$submission->url.'" data-toggle="tooltip" title="'.$submission->displayTitle.' by '.nl2br(htmlentities($submission->creditsPlain)).(isset($submission->content_warning) ? '<br/><strong>Content Warning:</strong> '.nl2br(htmlentities($submission->content_warning)) : '').'">'.view('widgets._gallery_thumb', ['submission' => $submission]).'</a>', $text);
            }
        }
    }

    return $text;
}


/**
 * Parses a piece of user-entered text to match userid mentions
 * and replace with a link.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseEmoteIDs($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\[emote=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $emote = App\Models\Emote::active()->where('id', $match)->first();
            if ($emote) {
                $users[] = $emote;
                $text = preg_replace('/\[emote='.$match.'\]/', '<img src="'.$emote->imageUrl.'">', $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match userid mentions
 * and replace with a link.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseEmoteNames($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\[emote=([A-Za-z0-9_-]+)/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $emote = App\Models\Emote::active()->where('name', $match)->first();
            if ($emote) {
                $users[] = $emote;
                $text = preg_replace('/\[emote='.$match.'\]/', '<img src="'.$emote->imageUrl.'">', $text);
            }
        }
    }

    return $text;
}

/**
 * Parses a piece of user-entered text to match an item id
 * and replace with an image.
 *
 * @param string $text
 * @param mixed  $users
 *
 * @return string
 */
function parseItemIDs($text, &$users) {
    $matches = null;
    $users = [];
    $count = preg_match_all('/\[item=([^\[\]&<>?"\']+)\]/', $text, $matches);
    if ($count) {
        $matches = array_unique($matches[1]);
        foreach ($matches as $match) {
            $item = App\Models\Item\Item::released()->where('id', $match)->first();
            if ($item) {
                $users[] = $item;
                $text = preg_replace('/\[item='.$match.'\]/', '<a href="'.$item->url.'"> <img src="'.$item->imageUrl.'"> </a>', $text);
            }
        }
    }

    return $text;
}