<?php
$numPanels=1;
global $get;
$PATH = '$PATH';
$HOME = isset($get['path'])?$get['path']:'$HOME';
// $HOME = '/var/www';
ob_start();
?>
<style>span{background:#ddd;}span.block{display:inline-block;}</style>
<p>otros tutoriales:</p>
http://mysql-apache-php.com/ffmpeg-install.htm
http://d.stavrovski.net/blog/install-ffmpeg-and-ffmpeg-php-in-centos-6-with-virtualmin
http://ghamail.com/forum/read.php?6,139,139
https://trac.ffmpeg.org/wiki/Using%20FFmpeg%20from%20PHP%20scripts
composer: https://getcomposer.org/doc/00-intro.md

lista x264 codecs: http://download.videolan.org/pub/videolan/x264/snapshots/


test server 1: http://68.109.244.197/videos/videotest.php
test server 2: http://68.109.244.198/videos/videotest.php
<hr/><hr/>

<b>Prerequisitos</b>
yum install autoconf automake gcc gcc-c++ git libtool make pkgconfig zlib-devel

<b>yasm</b>
rpm -i http://dl.fedoraproject.org/pub/epel/6/x86_64/yasm-1.2.0-1.el6.x86_64.rpm
<b>nasm</b>
rpm -i http://www.nasm.us/pub/nasm/releasebuilds/2.09.10/linux/nasm-2.09.10-1.x86_64.rpm

<hr/>
mkdir ~/ffmpeg_sources

<b>H.264 video encoder.</b>
modo 1 (ultima version):
cd  ~/ffmpeg_sources
git clone --depth 1 git://git.videolan.org/x264
cd x264
./configure --enable-static --enable-shared --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin"
make
make install
make distclean

modo 2 (7-7-2014):
cd  ~/ffmpeg_sources
wget http://download.videolan.org/pub/videolan/x264/snapshots/x264-snapshot-20130701-2245-stable.tar.bz2
tar jxvf x264-snapshot-20130701-2245-stable.tar.bz2
cd x264-snapshot-20130701-2245-stable
./configure --enable-static --enable-shared --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin"
make
make install
make distclean


<b>AAC audio encoder.</b>
cd  ~/ffmpeg_sources
git clone --depth 1 git://git.code.sf.net/p/opencore-amr/fdk-aac
cd fdk-aac
autoreconf -fiv
./configure --enable-shared --prefix="$HOME/ffmpeg_build"
make
make install
make distclean


<b>MP3 audio encoder.</b>
cd  ~/ffmpeg_sources
curl -L -O http://downloads.sourceforge.net/project/lame/lame/3.99/lame-3.99.5.tar.gz
tar zxvf lame-3.99.5.tar.gz
cd lame-3.99.5
./configure --enable-nasm --enable-shared --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin"
make
make install
make distclean

<b>Ogg bitstream library.</b>
cd  ~/ffmpeg_sources
curl -O http://downloads.xiph.org/releases/ogg/libogg-1.3.1.tar.gz
tar zxvf libogg-1.3.1.tar.gz
cd libogg-1.3.1
./configure --enable-shared --prefix="$HOME/ffmpeg_build"
make
make install
make distclean

<b>FFmpeg</b>
cd  ~/ffmpeg_sources
git clone --depth 1 git://source.ffmpeg.org/ffmpeg
cd ffmpeg
PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig"
export PKG_CONFIG_PATH
./configure --prefix="$HOME/ffmpeg_build" --extra-cflags="-I$HOME/ffmpeg_build/include" --extra-ldflags="-L$HOME/ffmpeg_build/lib" --bindir="$HOME/bin" --extra-libs=-ldl --enable-gpl --enable-nonfree --enable-libfdk_aac --enable-libmp3lame --enable-libx264 --enable-shared
make
make install
make distclean
hash -r
. ~/.bash_profile
cd ..

<b>acceso a librerias:</b>
nano /etc/ld.so.conf
agregar:
<span class="block">/usr/local/libevent-1.4.14b/lib
/usr/local/lib</span>


<hr/>
CON MAS CODECS:

<b>Opus audio decoder and encoder.</b>
cd  ~/ffmpeg_sources
curl -O http://downloads.xiph.org/releases/opus/opus-1.1.tar.gz
tar zxvf opus-1.1.tar.gz
cd opus-1.1
./configure --enable-shared --prefix="$HOME/ffmpeg_build"
make
make install
make distclean

<b>Vorbis audio encoder. Requires libogg.</b>
cd  ~/ffmpeg_sources
curl -O http://downloads.xiph.org/releases/vorbis/libvorbis-1.3.4.tar.gz
tar zxvf libvorbis-1.3.4.tar.gz
cd libvorbis-1.3.4
./configure --enable-shared --prefix="$HOME/ffmpeg_build" --with-ogg="$HOME/ffmpeg_build"
make
make install
make distclean

<b>VP8/VP9 video encoder.</b>
cd  ~/ffmpeg_sources
git clone --depth 1 https://chromium.googlesource.com/webm/libvpx.git
cd libvpx
./configure --disable-examples --enable-shared --prefix="$HOME/ffmpeg_build"
make
make install
make clean

<b>FFmpeg</b>
./configure --prefix="$HOME/ffmpeg_build" --extra-cflags="-I$HOME/ffmpeg_build/include" --extra-ldflags="-L$HOME/ffmpeg_build/lib" --bindir="$HOME/bin" --extra-libs=-ldl --enable-gpl --enable-nonfree --enable-libfdk_aac --enable-libmp3lame --enable-libopus --enable-libvorbis --enable-libvpx --enable-libx264 --enable-shared

<hr/>
<b>FFmpeg-devel</b>
rpm -Uhv http://apt.sw.be/redhat/el6/en/x86_64/dag/RPMS/rpmforge-release-0.5.3-1.el6.rf.x86_64.rpm
cd /etc/yum.repos.d
nano dag.repo <span>(repositorio yum de ffmpeg)</span>
<b>- agregar:</b>
<span class="block">[dag]
name=Dag RPM Repository for Red Hat Enterprise Linux
baseurl=http://apt.sw.be/redhat/el$releasever/en/$basearch/dag
gpgcheck=1
enabled=1
</span>
<b>- guardar con ctrl+x</b>
yum install ffmpeg-devel

<hr/>
<b>FFmpeg-Php</b>
mkdir /srv/build
cd /srv/build
wget http://downloads.sourceforge.net/project/ffmpeg-php/ffmpeg-php/0.6.0/ffmpeg-php-0.6.0.tbz2
tar -xjf ffmpeg-php-0.6.0.tbz2
cd ffmpeg-php-0.6.0/
phpize
./configure
sed -i 's#PIX_FMT_RGBA32#PIX_FMT_RGB32#' ./ffmpeg_frame.c
make
make install

<hr/>
<b>Revertir todos los cambios (incluyendo prerequisitos <span>exceptundo ffmpeg-devel y ffmpeg-php</span>)</b>
rm -rf ~/ffmpeg_build ~/ffmpeg_sources ~/bin/{ffmpeg,ffprobe,ffserver,lame,vsyasm,x264,yasm,ytasm}
hash -r

<b>Remover algunos prerequisitos</b>
rpm -e yasm
rpm -e nasm


<?php
$text=ob_get_contents();
ob_end_clean();

if($HOME!='$HOME') $text=str_replace('$HOME',$HOME,str_replace('~',$HOME,$text));
$text=preg_replace('/\r?\n/', '<br/>', trim($text));

echo $text;
