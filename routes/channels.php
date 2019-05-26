<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
