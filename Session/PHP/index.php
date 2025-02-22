<?php
define("ALPHA", str_split("abcdefghijklmnopqrstuvwxyz0123456789_-"));
ini_set("error_reporting",0);

if(isset($_GET['source'])){
	highlight_file(__FILE__);
}

include "flag.php";
$SEEDS = str_split($flag, 4);

function session_id_secure($id){
	global $SEEDS;
	mt_srand(intval(bin2hex($SEEDS[md5($id)[0] % count($SEEDS)]), 16));
	$id = "";
	for($i=0;$i<1000;$i++){
		$id .= ALPHA[mt_rand(0, count(ALPHA)-1)];
	}
	return $id;
}

if(isset($_POST['username']) && isset($_POST['password'])){
	session_id(session_id_secure($_POST['username'].$_POST['passsword']));
	session_start();
	echo "Thanks for signing up!";
}else{
	echo "Please provide the necessary data!";
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sess.io</title>
</head>
<body>
<h1>Sess.io</h1>
<h3>Sign up</h3>
<form method="POST">
	<label for="username">Username:</label><br>
	<input type="text" id='username' name="username"><br>
	
	<label for="password">Password:</label><br>
	<input type="text" id='password' name="password"><br>
	<button type="submit">Submit</button>
</form>
<p>To view the source code, <a href='?source'>click here.</a></p>
</body>
</html>

<!-- 11a = xk54lq9suky22gghwre_03ejg5o-46iam_oip4v_e5e8e8sn14qs0bwsp4387p5xziypme5yy8qt9gu93-qgtv3ejzu11k0u4bx1k-q_xzjdil7phd2wvoz68gzn0xog7gt_i8m4g12tpatj5cauylj9le49ht8geagjmopvf50kb5c9jqepx-fnbxh0x3n7ppfnrvg042t52by7sc0bbd8e70g5il0b2u20fr2h_0mp36kzagz3kjanc1ss8fjaj65ajrhhof-lnh4v75l6h4axucf-951nh_jkib-fs0bq3jh7im3rkgo2r1nilny617a6__lsqejuv_dwgwcdfewmhfj_h3q9gu_tfktsrg8ncmpnmmcpfc91pose12xfltbrozepz_vvii41iarwsb2_l2t30hvs065x488txhoukmfhtvh8eeio63db1hg68rk0biz7p1hh8_zktyz26slg9_xydk7ktsd4o0e1pfqyfjuz1-v2bws7v_-k-lzdz1fv10902l9b1elb-kz2uai3hm3fbvngu01z9r-jyry57f9ojp2mh8c81jry9971f_wflyg33j83rewb628kqoxmx_u2wa5d736ld-h-v59r-wrmg4h2lx6nvvwek3h5ba85nqnikwrcea9ridun165tylyt7xkbhzhmgsza55zc5mo6bp9qk7229c937iy7thpin-xmz3j9nr62776p9shszu3ny8p9r8-qlr16ejr0g2u00jppy_9g12i85eoy_n76tiihoseog8pd6uxfo-tbd0n24ubli95jbn4b8dw6d9x9ozu93bs8ly2vh3lu58041m_lcfme0u4yzavcvror5mth4kw7_eyntkt64d1tzuuplbtjqlj3j_81_p-haj501pqxb9c0kyl419_a-bu9y61y9e6js19p9uy2fhridira1bu7uyijha343tmac3tz8vb0bali9-jr-ag9vb703zbib5-884qyldpt -->

<!-- a = orl6l-4ozpfu_7tx6001osiaib-zr8x1w2bt0o0t4j311da1rdzui4z3oi8jamxb3tk2ayir5d4r5_s99wwu554a1e9imd1cuwtrn-qiiybdw6dy5u4uzn1bgvfx-wh1hcery--llkackpyg3hs4jdeu13bxlp2oev3498-llq_r07f1clq_f_ysdp01vp265tcpdzap_80xrrtbs8r_p_744k1m_iso2afsc8-w32lrixivh_pjknbpcqg4z_9gdbu_jqt-bn_4xxjqqenxryp5xgqz3w-hx7kshl87ume388hki8tb2ktgsv5lp5cer1he9sg0tnpg4f1blfolwix4qbd93qkczcv-7f1c63ggfr52gw-ubp-uk09lxwk1rwqvxl7kb5blqj00v7fe57ejtypfuw3rh2fzfu2n0ima58rqgyoh3ozo2n352l84yd-gx8hg4wcpikx3nnk-ga_t524r6j5inp7-k-lg6b0_2s2oo8bbgoummeualgwvmljsvltmf20nk76-5g6yowl5vypi9wwqix2lw2ojfvl4d_phkfayflk4-9g2el9c7wlah5i8n6duviv7rj1xk_vijctf4ik2z5xrxfc8xv2km69zqffxo-f9kibp-0sqhzozoafh8vh255porilh9pwmid84zkm2k9kj2dyqjft1__i8vxi21c7ugww216l-zh5ghxk458zohdhwe7rw3iryunx-dyjp_jmhuyctwpl3zynvx8wx5222qm843mzzva1_kso6mhfvend6bkii0eifzx-t6ek2he635ezectt3oehwyd44o_7kajkxen58sztindndzv1140_1p440f89bm3yp82z8xs9zfjptre4qihes7srxikd_zgehhfg5mo495_vbkxrt45xg66n9g3wqnx359c88o-pr0u1rhjah7bc896llrllj6quk72l0mej4jh1u0rqt4utkgch4u7hb4k364dq2ohorrxhl -->


///////////////

<!-- 11a = sc_0nsixk5_mrr8xa5f4hday65tfxxbhx_bc-h282v9cq0v-c7uqmrrvr3dxohraf78i0emwdtkg1dlrpe9p-u9nss_pp4hjw_1suj3q7ptdc53mkyrh2idnlaj0qys5i5l-753macfng3r18cv99spw6w-rfg6kaszppn55ixq08q4kive0jr1l31bipcdx53rf0m5wjtah4fsmm36bive6lw3vt66tioky7h1uyx4_2uvkgi8jzh8sfavfo84hco4t-1oj6a5b536zgyq1g1-i_3tuueqh5zhfba5f2krxwissgpj14s2vwf_d0g4egl8_v3yxd781_w764v_myk8len471xifr4e1r_h5tt52uz6evkt8e2y1sgai5lz-1eruvlz_v6qsstuo77io9vf077hohd43kw9v-9xri6xevebt7zfq620ft6swlskv8bu_3142uomqxjbzlz-6dil14n46l0p06ehf4e91npqv7_nva9sk5gk11yiv_k79224xwkfdt3fmej5udmu1dwgxhuoeu4uzisey_2iplyozm4s_xl5t6hcjgm4ajn348egmaho0-cwz_e3275pb_6iiq0j773qniwgho53b5fuazl1e10ki8kbo8q6r0h7rvo6-irj_o0v7ve5vp-3ku0zlojz1ychhp5bdzlgiqmjre3lap8qljf3i3dav0z_2dj9boh29qo_0uhqczp2myh-8_zkhhlx1vxwbmc65par9wzjmg5dom449cqdcxvxwgcu1vlqj1mombe-px1g6pbbap_e2153qk4yikd46ufwk1dklmsdd_eixmrvy1lq07nci86xa1nmgjgmrawf5-mf8mbpm4hi-fiznzguqm8ttozxxdk7h5lgbp7jonq0eew6m58oyws_h7_44ggc_sgbvy7_oxvtyyds-w9s664afuk_8xlekl_4-txneg6v5jure99mh9z1ee_o2113qdjl8ge6tsx_-d2_-jxl7