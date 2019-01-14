<?php
namespace Oliver;

trait GravatarTrait {
    public function gravatar(string $email, int $size = 60) : string
    {
        $rating = 'pg';
        $default = "https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png"; // Set a Default Avatar
        $email = md5(strtolower(trim($email)));
        $gravurl = "http://www.gravatar.com/avatar/$email?d=$default&s=200&r=$rating";
        return '<img style="width: ' . $size . 'px; height: ' . $size . 'px;" class="profile-image" src="' . $gravurl . '" width="{$size}" height="{$size}" border="0" alt="Avatar">';
    }
}
