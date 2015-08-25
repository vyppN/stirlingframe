<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/25/2015 AD
 * Time: 12:06 AM
 */

namespace lib;


class Color
{
    const RESET = "\033[0m";
    const RED = "\033[31m";
    const GREEN = "\033[32m";
    const YELLOW = "\033[33m";
    const BLUE = "\033[34m";
    const MEGENTA = "\033[35m";
    const CYAN = "\033[36m";

    const BOLD = "\033[1m";
    const BOLD_RED = "\033[1;31m";
    const BOLD_GREEN = "\033[1;32m";
    const BOLD_YELLOW = "\033[1;33m";
    const BOLD_BLUE = "\033[1;34m";
    const BOLD_MEGENTA = "\033[1;35m";
    const BOLD_CYAN = "\033[1;36m";

    const BOLD_UNDERLINE = "\033[1;4m";
    const BOLD_UNDERLINE_RED = "\033[1;4;31m";
    const BOLD_UNDERLINE_GREEN = "\033[1;4;32m";
    const BOLD_UNDERLINE_YELLOW = "\033[1;4;33m";
    const BOLD_UNDERLINE_BLUE = "\033[1;4;34m";
    const BOLD_UNDERLINE_MEGENTA = "\033[1;4;35m";
    const BOLD_UNDERLINE_CYAN = "\033[1;4;36m";

    const UNDERLINE = "\033[4m";
    const UNDERLINE_RED = "\033[4;31m";
    const UNDERLINE_GREEN = "\033[4;32m";
    const UNDERLINE_YELLOW = "\033[4;33m";
    const UNDERLINE_BLUE = "\033[4;34m";
    const UNDERLINE_MEGENTA = "\033[4;35m";
    const UNDERLINE_CYAN = "\033[4;36m";
}