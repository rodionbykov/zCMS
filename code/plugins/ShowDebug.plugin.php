<?php
/**
 *
 * ShowDebug.php
 *
 * Version 0.5
 * Last Modified: 09/09/2007
 *
 * @category   Fusebox
 * @author     Sergiy Galashyn <trovich@gmail.com>, 02 Sep 2007
 *
 *
 * INFO:
 * Script used to append debug output to each fusebox page, that works similary to ColdFusion debug output
 * (hiding content on section header click, hides block if array is empty) and looks like phpinfo() output.
 * Doesn't need additional apache/php modules.
 *
 * USAGE:
 * 1. Development mode enables debugging.
 * 2. Add to preProcess and postProcess phases call <plugin name="show_debug" template="ShowDebug.php" path="" />
 * 3. Copy script into plugins directory.
 * 4. Select arrays to show in debug by setting any TRUE values in $allowedDebugVariables array in any site template.
 * E.g. if you need to show $_ENV status on certain page (it's hidden by default), use next code:
 * $allowedDebugVariables['_ENV'] = 1;
 * Or if you don't want to see queries on page use code:
 * $allowedDebugVariables['queries'] = 0;
 * Undefined keys will be visible according to default values, set in $defaultDebugVariables;
 * Notice: enabling full $application debug not recommended because of huge output. Use parts of it instead
 * ("circuits" included by default).
 *
 * BONUS:
 * Script can be used to display any custom variables. For simple types will be displayed their values,
 * for objects - raw print_r() (see notice #1 below). This way allows to turn on/off all debug output on all site.
 * To use this feature add next code to any plugin in preProcess phase:
    $arrDebugStack = array();
    function _debug($var,$name) {
        global $arrDebugStack;
        global $application;
        // used to avoid memory spending if debug off, but not required
        if ($application["fusebox"]["mode"] == "development") {
            $arrDebugStack[$name] = $var;
            return true;
        }
        else {
            return false;
        }
    }
 * To add variable to stack use code like:
   _debug($variableValue,'displayName');
 * Variable dump will appear after genaral information section.
 *
 *
 * NOTICE #1: looping over objects public properties implemented only in PHP5, this script doesn't use it.
 * To add such possibility: replace line 39
    if (is_array($valueInner)) {
 * to
   if (is_array($valueInner) || is_object($valueInner)) {
 * and clear lines from 46 to 50.
 *
 * NOTICE #2: queries record count can be shown if update Clone 4 DB class by adding property $fQueriesRecords and
 * updating query method:
  function query($sql){
        array_push($this->fQueries, $sql);
        array_push($this->fQueriesRecords, $this->fRowsNumber);
  }
 *
 *
 * TODO: Add includes stack -- which files being included during execution.
 * TODO: Improve queries list -- add execution time.
 *   phpMyAdmin uses this
 *   $querytime_before = array_sum(explode(' ', microtime()));
 *   ...query
 *   $querytime_after = array_sum(explode(' ', microtime()));
 *
 */

if ($application["fusebox"]["mode"] == "development" && $application["fusebox"]["debug"] == "true") {

if ($myFusebox['thisPhase'] == "preProcess") {

    // start time counter
    if (substr(PHP_VERSION,0,1) == "4") {
        list($usec, $sec) = explode(" ", microtime());
        $timeStart = ((float)$usec + (float)$sec);
    }
    else {
        $timeStart = microtime(true);
    }

}
else {

    // pre-defined debug variables
    $arrSystemDebugStack = array(
        "queries" => array(
                        "sql" => empty($db->fQueries) ? array() : $db->fQueries,
                        "records" => empty($db->fQueriesRecords) ? array() : $db->fQueriesRecords
                        ),
        "attributes" => empty($attributes) ? array() : $attributes,
        "_SERVER" => $_SERVER,
        "_POST" => $_POST,
        "_GET" => $_GET,
        "_COOKIE" => $_COOKIE,
        "_SESSION" => $_SESSION,
        "_FILES" => $_FILES,
        "_ENV" => $_ENV,
        "application" => empty($application) ? array() : $application,
        "application['fusebox']['circuits']" => empty($application["fusebox"]["circuits"]) ? array() : $application["fusebox"]["circuits"]
    );

    // variables to show by default
    $defaultDebugVariables = array(
        "queries" => 1,
        "attributes" => 1,
        "_SERVER" => 1,
        "_POST" => 1,
        "_GET" => 1,
        "_COOKIE" => 0,
        "_SESSION" => 1,
        "_FILES" => 0,
        "_ENV" => 0,
        "application" => 0,
        "application['fusebox']['circuits']" => 0
    );

    if (empty($allowedDebugVariables)) {
        // if no debug vars visibility set - show default layout
        $allowedDebugVariables = $defaultDebugVariables;
    }
    else {
        // else set custom visibility for existing keys
        foreach ($defaultDebugVariables as $key => $val) {
            if (!isset($allowedDebugVariables[$key])) {
                $allowedDebugVariables[$key] = $val;
            }
        }
    }

    // basic build debug function
    function builDebug($id,$valueOuter,$keyOuter=false, $keyCounter=false) {

        if (!$keyCounter) {
            $keyCounter = 1;
        }

        if (is_array($valueOuter)) {

            if (!count($valueOuter)) {

                echo "[empty array]";

            }
            else {

                echo "\n".'<table border="0" cellpadding="0" cellspacing="0" class="debug_container">'."\n";

                echo "\n".'<tr><td class="debug_header" id="'.$id.'_'.$keyCounter.'_header" colspan="2" onclick="toggleVisibility(\''.$id.'_'.$keyCounter.'\');" title="Click to toggle visibility">array</td></tr>'."\n";
                echo "<tr><td class=\"debug_container\">\n".'<table border="0" cellpadding="3" cellspacing="0" class="debug" id="'.$id.'_'.$keyCounter.'">'."\n";

                foreach($valueOuter as $keyInner => $valueInner) {

                    echo '<tr><td class="debug_key">'.$keyInner.'</td><td class="debug_value">';

                    // experimental for objects!
                    if (is_array($valueInner) || (is_object($valueInner) && (intval(substr(PHP_VERSION,0,1)) > 5))) {
                        builDebug($id,$valueInner,$keyInner,$keyCounter+1);
                    }
                    elseif (is_object($valueInner)) {
                        echo "<pre class=\"debug\">";
                        print_r($valueInner);
                        echo "</pre>";
                    }
                    else {

                        if ($valueInner == "") {
                            echo "[empty string]";
                        }
                        else {
                            echo $valueInner;
                        }

                    }

                    echo "</td></tr>\n";

                }

                echo "</table>\n</td></tr>\n</table>\n";

            }

        }

    }

    // stop time counter
    if (substr(PHP_VERSION,0,1) == "4") {
        list($usec, $sec) = explode(" ", microtime());
        $timeEnd = ((float)$usec + (float)$sec);
    }
    else {
        $timeEnd = microtime(true);
    }
    $totalTime = $timeEnd - $timeStart;

?>
</td></td></td></th></th></th></tr></tr></tr></table></table></table></a></abbrev></acronym></address></applet></au></b></banner></big></blink></blockquote></bq></caption></center></cite></code></comment></del></dfn></dir></div></div></dl></em></fig></fn></font></form></frame></frameset></h1></h2></h3></h4></h5></h6></head></i></ins></kbd></listing></map></marquee></menu></multicol></nobr></noframes></noscript></note></ol></p></param></person></plaintext></pre></q></s></samp></script></select></small></strike></strong></sub></sup></table></td></textarea></th></title></tr></tt></u></ul></var></wbr></xmp>

<style type="text/css">
    h2.debug {
        font-family: sans-serif;
        font-size: 18px;
        text-align: left;
    }
    h3.debug {
        font-family: sans-serif;
        font-size: 16px;
        text-align: left;
    }
    table.debug {
        border-collapse: collapse;
        width: auto;
    }
    table.hidden {
        display: none;
    }
    table.debug_container {
        width: auto;
    }
    td.debug_container {
        padding: auto;
        margin: auto;
    }
    .debug_key {
        font-family: sans-serif;
        border: 1px solid #000000;
        font-size: 12px;
        vertical-align: top;
        background-color: #99ccff;
        color: #000000;
        padding: 2px;
        margin: 2px;
    }
    .debug_value {
        font-family: sans-serif;
        border: 1px solid #000000;
        font-size: 12px;
        vertical-align: top;
        background-color: #cccccc;
        color: #000000;
        padding: 2px;
        margin: 2px;
    }
    .debug_header {
        font-family: sans-serif;
        border: 1px solid #000000;
        border-bottom: 0;
        font-size: 13px;
        font-weight: bold;
        background-color: #9999cc;
        color: #ffffff;
        padding: 4px;
        width: auto;
    }
    .debug_header_border {
        font-family: sans-serif;
        border: 1px solid #000000;
        font-size: 13px;
        vertical-align: top;
        font-weight: bold;
        background-color: #9999cc;
        color: #ffffff;
        padding: 4px;
        width: auto;
    }
    pre.debug {
        font-size: 12px;
        margin: 3px;
        font-family: monospace;
        width: 100%;
    }
</style>

<script type="text/javascript">
<!--
function toggleVisibility(id) {
    item = document.getElementById(id);
    if (item.className == "debug") {
        item.className = "hidden";
        header = document.getElementById(id+"_header");
        header.className = "debug_header_border";
    }
    else {
        item.className = "debug";
        header = document.getElementById(id+"_header");
        header.className = "debug_header";
    }
    return true;
}
//-->
</script>

<div style="width: auto; padding: 10px; margin: 0;">

<hr>
<h2 class="debug">Debugging Information</h2>
<table border="0" cellpadding="0" cellspacing="0" class="debug">
    <tr><td class="debug_key">Server</td><td class="debug_value"><?=$_SERVER["SERVER_SOFTWARE"];?></td></tr>
    <tr><td class="debug_key">Template</td><td class="debug_value"><?=$_SERVER["SCRIPT_NAME"];?></td></tr>
    <tr><td class="debug_key">Time Stamp</td><td class="debug_value"><?=strftime("%D %T",time());?></td></tr>
    <tr><td class="debug_key">User Agent</td><td class="debug_value"><?=$_SERVER["HTTP_USER_AGENT"];?></td></tr>
    <tr><td class="debug_key">Remote IP</td><td class="debug_value"><?=$_SERVER["REMOTE_ADDR"];?></td></tr>
    <tr><td class="debug_key">Host Name</td><td class="debug_value"><?=$_SERVER["SERVER_NAME"];?></td></tr>
    <tr><td class="debug_key">Execution Time</td><td class="debug_value"><?=sprintf("%.3f",$totalTime);?> seconds</td></tr>
</table>
<br />


<?php
    // show custom variables stack
    if (!empty($arrDebugStack) && is_array($arrDebugStack)) {
?>
<hr>
<h2 class="debug">Custom variables stack</h2>
<br />
<?php
        foreach($arrDebugStack as $name => $value) {
?>
<hr>
<h3 class="debug">$<?=str_replace("$","",$name);?></h3>
<?php
            if (is_array($value)) {
                builDebug($name,$value);
            }
            elseif (is_object($value)) {
?>
<table border="0" cellpadding="0" cellspacing="0" class="debug_container">
<tr><td class="debug_header" id="var_<?=$name;?>_header" colspan="2" onclick="toggleVisibility('var_<?=$name;?>');" title="Click to toggle visibility">object</td></tr>
<tr><td class="debug_container">
    <table border="0" cellpadding="3" cellspacing="0" class="debug" id="var_<?=$name;?>">
    <tr><td class="debug_key"><?=$name;?></td>
    <td class="debug_value">
    <pre class="debug">
    <?=print_r($value);?>
    </pre>
    </td></tr>
    </table>
</td></tr>
</table>
<?php
            }
            else {
?>
<table border="0" cellpadding="0" cellspacing="0" class="debug_container">
<tr><td class="debug_header" id="var_<?=$name;?>_header" colspan="2" onclick="toggleVisibility('var_<?=$name;?>');" title="Click to toggle visibility">simple</td></tr>
<tr><td class="debug_container">
    <table border="0" cellpadding="3" cellspacing="0" class="debug" id="var_<?=$name;?>">
    <tr><td class="debug_key"><?=$name;?></td><td class="debug_value"><?=$value;?></td></tr>
    </table>
</td></tr>
</table>
<?php
            }
?>
<br />
<?php
}
    }
?>

<?php
    // show queries list
    if ($allowedDebugVariables["queries"] && !empty($arrSystemDebugStack['queries'])) {
?>
<hr>
<h3 class="debug">Queries (total <?=count($arrSystemDebugStack['queries']['sql']);?>)</h3>
<table border="0" cellpadding="0" cellspacing="0" class="debug_container">
<tr><td class="debug_header" id="queries_header" colspan="2" onclick="toggleVisibility('queries');" title="Click to toggle visibility">array</td></tr>
<tr><td class="debug_container">
    <table border="0" cellpadding="3" cellspacing="0" class="debug" id="queries">
<?php
        foreach($arrSystemDebugStack['queries']['sql'] as $key => $query) {
            $recs = "";
            if (isset($arrSystemDebugStack['queries']['records'][$key])) $recs = " <strong>(".$arrSystemDebugStack['queries']['records'][$key]." records)</strong>";
?>
    <tr><td class="debug_key" align="right" nowrap><?=$key;?>)</td><td class="debug_value"><pre><?=$query;?></pre><?=$recs;?></td></tr>
<?php
        }
?>
    </table>
</td></tr>
</table>
<br />
<?php
    }
?>

<?php
    // delete queries from stack
    unset($arrSystemDebugStack['queries']);
    // show the rest variables
    foreach ($arrSystemDebugStack as $key => $variable)  {
        if($allowedDebugVariables[$key] && !empty($variable)) { ?>
        <hr>
        <h3 class="debug">$<?=str_replace("$","",$key);?></h3>
        <?=builDebug($key,$variable);?>
        <br />
<?php
        }
    }
?>


</div>

<?php

}

}

?>