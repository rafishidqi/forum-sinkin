# forum-sinkin
-------------------------------
    Aplikasi Forum Diskusi - SinkIn
-------------------------------

Forum SinkIn adalah sebuah platform yang memungkinkan pengguna login, membuat postingan, dan berinteraksi dengan konten. Pengguna dapat mengunggah gambar dari galeri lokal, yang akan diunggah ke server dan disimpan sebagai URL di database, terintegrasi penuh dengan PHP API. Pengguna juga bisa melakukan voting (upvote/downvote), menyimpan, serta mengedit postingan mereka.

-------------------------------
    Fitur
-------------------------------

Web (Administrator)
- Melihat Jumlah User, Jumlah Postingan, Jumlah Kategori, Jumlah Laporan.
- Melihat Data User
- Melihat Data Postingan beserta detailnya
- Melihat Data Laporan beserta detailnya
- Melihat Data Kategori beserta detailnya
- Ban Postingan
- Delete Postingan
- Delete Kategori
- Edit Kategori
- Menghapus Komentar
- Mengelola Laporan
- Login

Android (User)
- Melihat Postingan
- Melihat Detail Postingan
- Upvote, Downvote, Comment, Save, Report Posts
- Hapus Komentar
- Melihat dan Mengedit Profile
- Melihat dan Mengikuti Kategori
- Menambah Kategori
- Mencari Postingan
- Menambah Postingan
- Login
- Logout
- Register

-------------------------------
    Information for Developments
-------------------------------
- Android Studio Iguana
- XAMPP Control Panel PHP 8.12.2
- Visual Studio Code
- Laravel 12
- Tailwind CSS + Vite
- API PHP Native

-------------------------------
    Installation and Setup Projects
-------------------------------

Website
1. Create new folder on your device.
2. Open the folder with Visual Studio Code.
3. Clone this repo.
4. Move zip folder "api-sinkin.zip" to your htdocs folder (if you use XAMPP) and extract folder.
5. Open the CMD terminal on your project and write "npm run dev" to run vite.
6. Open the Powershell terminal on your project and write "php artisan serve".

Android
1. Create new folder on your device.
2. Open the folder with Android Studio Iguana.
3. Clone the Android Project repo, [here](https://github.com/rafishidqi/android-forum-sinkin)
4. Open CMD terminal and write "ipconfig".
5. Copy your IPv4 Address.
6. Open the RetrofitClient.kt file.
7. Change the base url with your IPv4 Address.
8. Run the project on your device.
9. Make sure the api and the android device using the same connection.

-------------------------------
Thank You
-------------------------------
