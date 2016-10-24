<html>
<head>
<title>Menerjemahkan dengan Google Translate API</title>
</head>
<body>
<h2>Masukkan teks dalam Bahasa Indonesia</h2>
<form method="post"><br>
<input type="text" size=50 name="teks"><br>
<select name="tujuan">
    <option value="en">Inggris</option>
    <option value="it">Italia</option>
    <option value="es">Spanyol</option>
    <option value="fr">Perancis</option>   
</select>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="submit" value="Terjemahkan" name="oke">
</form>

</body>
</html>