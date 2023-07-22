<?php

namespace Colorfield\Mastodon;

enum HttpOperation
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
}
