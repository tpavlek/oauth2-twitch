<?php

return [
    'clientId' => getenv('TWITCH_CLIENT_ID'),
    'clientSecret' => getenv('TWITCH_CLIENT_SECRET'),
    'redirectUri' => getenv("TWITCH_REDIRECT_URI")
];
