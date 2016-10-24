@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<div class="panel-heading"></div>
<div class="panel-body">			
	<div class="panel panel-info">
      <div class="panel-heading">Membuat stub</div>
      <div class="panel-body">
      	<ol>
      		<li>Pilih menu Komponen, pilih stub</li>
      		<li>Klik tombol tambah stub kemudian isi form yang tersedia</li>
      		<li>Klik "tambah isian" untuk menambah jumlah baris stub</li>
      		<li>Nama stub adalah nama unik untuk setiap stub</li>
      		<li>Label stub adalah judul stub</li>
      		<li>Label stub (english) adalah judul stub dalam bahasa inggris</li>
      		<li>Stub tipe static adalah stub yang tidak mengalami perubahan, misalnya stub bulan</li>
      		<li>Setelah selesai mengisi form, tekan simpan</li>
      	</ol>
      </div>
    </div>

	<h2>Gambaran Umum</h2>		
    <center><iframe width="560" height="315" src="https://www.youtube.com/embed/XFaHx_7-zeE" frameborder="0" allowfullscreen></iframe></center>

    <h2>Pengentrian Data</h2>
    <center><iframe width="560" height="315" src="https://www.youtube.com/embed/HsvVdpaqQVI" frameborder="0" allowfullscreen></iframe></center>

    <h2>Tombol-tombol di Beranda</h2>
    <center><iframe width="560" height="315" src="https://www.youtube.com/embed/3PYg7AqmyyA" frameborder="0" allowfullscreen></iframe></center></div>

    <div class="panel panel-danger">
      <div class="panel-heading">Konversi ke pdf</div>
      <div class="panel-body">
        <ul>
          <li>Proses ini mungkin memakan waktu lama</li>
          <li>Tunggu hingga proses selesai, sekurang-kuragnya 5 menit</li>
          <li>Setelah selesai, file akan terdownload otomatis. Untuk melihatnya, gunakan pdf viewer</li>
        </ol>
      </div>
    </div>
</div>
</div>
</div>
@endsection

@section('postJquery')
    @parent
@endsection