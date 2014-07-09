<?php
global $get;
$PATH = '$PATH';
$HOME = isset($get['path'])?$get['path']:'$HOME';
// $HOME = '/var/www';
$text = <<<EOD

<b>Prerequisitos</b>
yum install autoconf automake gcc gcc-c++ git libtool make pkgconfig zlib-devel

<b>yasm</b>
rpm -i http://dl.fedoraproject.org/pub/epel/6/x86_64/yasm-1.2.0-1.el6.x86_64.rpm
<b>nasm</b>
rpm -i http://www.nasm.us/pub/nasm/releasebuilds/2.09.10/linux/nasm-2.09.10-1.x86_64.rpm

<hr/>
mkdir ~/ffmpeg_sources
cd  ~/ffmpeg_sources

<b>H.264 video encoder.</b> 
git clone --depth 1 git://git.videolan.org/x264
cd x264
./configure --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin" --enable-static --enable-shared
make
make install
make distclean
cd ..

<b>AAC audio encoder.</b> 
git clone --depth 1 git://git.code.sf.net/p/opencore-amr/fdk-aac
cd fdk-aac
autoreconf -fiv
./configure --prefix="$HOME/ffmpeg_build" --enable-shared
make
make install
make distclean
cd ..


<b>MP3 audio encoder.</b>
curl -L -O http://downloads.sourceforge.net/project/lame/lame/3.99/lame-3.99.5.tar.gz
tar xzvf lame-3.99.5.tar.gz
cd lame-3.99.5
./configure --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin" --enable-nasm --enable-shared
make
make install
make distclean
cd ..


<b>Opus audio decoder and encoder.</b> 
curl -O http://downloads.xiph.org/releases/opus/opus-1.1.tar.gz
tar xzvf opus-1.1.tar.gz
cd opus-1.1
./configure --prefix="$HOME/ffmpeg_build" --enable-shared
make
make install
make distclean
cd ..


<b>Ogg bitstream library.</b> 
curl -O http://downloads.xiph.org/releases/ogg/libogg-1.3.1.tar.gz
tar xzvf libogg-1.3.1.tar.gz
cd libogg-1.3.1
./configure --prefix="$HOME/ffmpeg_build" --enable-shared
make
make install
make distclean
cd ..


<b>Vorbis audio encoder. Requires libogg.</b>
curl -O http://downloads.xiph.org/releases/vorbis/libvorbis-1.3.4.tar.gz
tar xzvf libvorbis-1.3.4.tar.gz
cd libvorbis-1.3.4
./configure --prefix="$HOME/ffmpeg_build" --with-ogg="$HOME/ffmpeg_build" --enable-shared
make
make install
make distclean
cd ..


<b>VP8/VP9 video encoder.</b>
git clone --depth 1 https://chromium.googlesource.com/webm/libvpx.git
cd libvpx
./configure --prefix="$HOME/ffmpeg_build" --disable-examples --enable-shared
make
make install
make clean
cd ..


<b>FFmpeg</b>
git clone --depth 1 git://source.ffmpeg.org/ffmpeg
cd ffmpeg
PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig"
export PKG_CONFIG_PATH
./configure --prefix="$HOME/ffmpeg_build" --extra-cflags="-I$HOME/ffmpeg_build/include" --extra-ldflags="-L$HOME/ffmpeg_build/lib" --bindir="$HOME/bin" --extra-libs=-ldl --enable-gpl --enable-nonfree --enable-libfdk_aac --enable-libmp3lame --enable-libopus --enable-libvorbis --enable-libvpx --enable-libx264 --enable-shared
make
make install
make distclean
hash -r
. ~/.bash_profile
cd ..

<b>FFmpeg-Php</b>
cd /usr/local/src
wget http://garr.dl.sourceforge.net/sourceforge/ffmpeg-php/ffmpeg-php-0.6.0.tbz2
tar jxvf ffmpeg-php-0.6.0.tbz2
cd ffmpeg-php-0.6.0
phpize
./configure
make
make install

<hr/>
<b>Revertir todos los cambios (incluyendo prerequisitos)</b>
rm -rf ~/ffmpeg_build ~/ffmpeg_sources ~/bin/{ffmpeg,ffprobe,ffserver,lame,vsyasm,x264,yasm,ytasm}
hash -r

<b>Remover algunos prerequisitos</b>
rpm -e yasm
rpm -e nasm

EOD;

if($HOME!='$HOME') $text=str_replace('~',$HOME,$text);
$text=preg_replace('/\r?\n/', '<br/>', trim($text));

echo $text;