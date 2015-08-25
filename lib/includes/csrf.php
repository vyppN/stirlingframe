<?php
/* CSRF */
function store_in_session($key, $value)
{
    if (isset($_SESSION)) {
        $_SESSION[$key] = $value;
    }
}

function unset_session($key)
{
    $_SESSION[$key] = ' ';
    unset($_SESSION[$key]);
}

function get_from_session($key)
{
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return false;
    }
}

function generate_token($unique_form_name)
{
    if (function_exists("hash_algos") and in_array("sha512", hash_algos())) {
        $token = hash("sha512", mt_rand(0, mt_getrandmax()));
    } else {
        $token = ' ';
        for ($i = 0; $i < 128; ++$i) {
            $r = mt_rand(0, 35);
            if ($r < 26) {
                $c = chr(ord('a') + $r);
            } else {
                $c = chr(ord('0') + $r - 26);
            }
            $token .= $c;
        }
    }
    store_in_session($unique_form_name, $token);
    return $token;
}

function validate_token($unique_form_name, $token_value)
{
    $token = get_from_session($unique_form_name);
    if ($token === false) {
        return false;
    } elseif ($token === $token_value) {
        $result = true;
    } else {
        $result = false;
    }
    unset_session($unique_form_name);
    return $result;
}

function replace_forms($form_data_html)
{
    $count = preg_match_all("/<form(.*?)>(.*?)<\\/form>/is", $form_data_html, $matches, PREG_SET_ORDER);
    if (is_array($matches)) {
        foreach ($matches as $m) {
            if (strpos($m[1], "nocsrf") !== false) {
                continue;
            }
            $name = "CSRFGuard_" . mt_rand(0, mt_getrandmax());
            $token = generate_token($name);
            $form_data_html = str_replace($m[0],
                "<form{$m[1]}>
<input type='hidden' name='CSRFName' value='{$name}' />
<input type='hidden' name='CSRFToken' value='{$token}' />{$m[2]}</form>", $form_data_html);
        }
    }
    return $form_data_html;
}

function inject()
{
    $data = ob_get_clean();
    $data = replace_forms($data);
    echo $data;
}

function csrfguard_start()
{
    if (count($_POST)) {
        if (!isset($_POST['CSRFName']) or !isset($_POST['CSRFToken'])) {
            die("No CSRFName found, probable invalid request.");
        }
        $name = $_POST['CSRFName'];
        $token = $_POST['CSRFToken'];
        if (!validate_token($name, $token)) {
            die("Invalid CSRF token.");
        }
    }
    ob_start();
    /* adding double quotes for "inject" to prevent:
          Notice: Use of undefined constant inject - assumed 'inject' */
    register_shutdown_function("inject");
}

csrfguard_start();