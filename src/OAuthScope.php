<?php

namespace Colorfield\Mastodon;

enum OAuthScope
{
    case read;
    case write;
    case follow;
    case push;
}
