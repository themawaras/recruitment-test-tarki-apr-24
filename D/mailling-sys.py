import datetime

class Surat:
    nomor_surat_terakhir = 0

    def __init__(self, klasifikasi, tanggal_surat, pengirim, penerima, perihal, isi):
        Surat.nomor_surat_terakhir += 1
        self.nomor_surat = f"{klasifikasi}/{Surat.nomor_surat_terakhir:03}/{tanggal_surat.month}/{tanggal_surat.year}"
        self.tanggal_surat = tanggal_surat
        self.pengirim = pengirim
        self.penerima = penerima
        self.perihal = perihal
        self.isi = isi

    def tampilkan_detail(self):
        print("Nomor Surat:", self.nomor_surat)
        print("Tanggal Surat:", self.tanggal_surat.strftime("%d-%m-%Y"))
        print("Pengirim:", self.pengirim)
        print("Penerima:", self.penerima)
        print("Perihal:", self.perihal)
        print("Isi Surat:", self.isi)

class PengelolaSurat:
    def __init__(self):
        self.daftar_surat = []

    def tambah_surat(self, surat):
        self.daftar_surat.append(surat)

    def cari_surat(self, nomor_surat):
        for surat in self.daftar_surat:
            if surat.nomor_surat == nomor_surat:
                return surat
        return None

    def tampilkan_daftar_surat(self):
        for surat in self.daftar_surat:
            print("Nomor Surat:", surat.nomor_surat)
            print("Tanggal Surat:", surat.tanggal_surat.strftime("%d-%m-%Y"))
            print("Pengirim:", surat.pengirim)
            print("Penerima:", surat.penerima)
            print("Perihal:", surat.perihal)
            print("Isi Surat:", surat.isi)
            print("")

def main():
    pengelola_surat = PengelolaSurat()

    while True:
        print("\nMenu:")
        print("1. Tambah Surat")
        print("2. Cari Surat")
        print("3. Tampilkan Daftar Surat")
        print("4. Keluar")
        pilihan = input("Pilih menu: ")

        if pilihan == '1':
            print("\nPilih Klasifikasi Surat:")
            print("1. Pemb. (Pemberitahuan)")
            print("2. Ed. (Edaran)")
            print("3. Pengm. (Pengumuman)")
            print("4. Su-Ket. (Surat Keterangan)")
            klasifikasi_pilihan = input("Pilih klasifikasi: ")
            if klasifikasi_pilihan == '1':
                klasifikasi = "Pemb."
            elif klasifikasi_pilihan == '2':
                klasifikasi = "Ed."
            elif klasifikasi_pilihan == '3':
                klasifikasi = "Pengm."
            elif klasifikasi_pilihan == '4':
                klasifikasi = "Su-Ket."
            else:
                print("Klasifikasi tidak valid. Surat gagal ditambahkan.")
                continue

            tanggal_surat = datetime.datetime.strptime(input("Tanggal Surat (dd-mm-yyyy): "), "%d-%m-%Y")
            pengirim = input("Pengirim: ")
            penerima = input("Penerima: ")
            perihal = input("Perihal: ")
            isi = input("Isi Surat: ")
            surat = Surat(klasifikasi, tanggal_surat, pengirim, penerima, perihal, isi)
            pengelola_surat.tambah_surat(surat)
            print("Surat berhasil ditambahkan!")

        elif pilihan == '2':
            nomor_surat_cari = input("Nomor Surat yang dicari: ")
            surat_cari = pengelola_surat.cari_surat(nomor_surat_cari)
            if surat_cari:
                print("\nDetail Surat dengan Nomor Surat", nomor_surat_cari)
                surat_cari.tampilkan_detail()
            else:
                print("Surat dengan Nomor Surat", nomor_surat_cari, "tidak ditemukan.")

        elif pilihan == '3':
            print("\nDaftar Surat:")
            pengelola_surat.tampilkan_daftar_surat()

        elif pilihan == '4':
            break

        else:
            print("Pilihan tidak valid. Silakan pilih menu yang sesuai.")

if __name__ == "__main__":
    main()
