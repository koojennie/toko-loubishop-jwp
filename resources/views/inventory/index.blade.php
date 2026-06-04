@extends('layouts.app')
@section('page-header')
  <div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
      <div class="row">
        <div class="col-md-12">
          <div class="flex-wrap d-flex justify-content-between align-items-center">
            <div>
              <h1>Persediaan Barang</h1>
              <p>Kelola transaksi barang masuk, barang keluar, dan pantau pergerakan stok
                persediaan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="iq-header-img">
      <img src="{{ asset('hope-ui/assets/images/dashboard/top-header.jpg') }}" alt="header"
        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
    </div>
  </div>
@endsection
@section('content')
  <div class="container-fluid content-inner mt-n5 py-0">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="header-title">
              <h4 class="card-title mb-1">Data Persediaan Barang</h4>
              <p class="mb-0 text-secondary">
                Tabel transaksi keluar masuk barang Toko Bangunan Jwp.
              </p>
            </div>
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-success btn-sm btn-barang-masuk" data-bs-toggle="modal"
                data-bs-target="#modalBarangMasuk">
                Barang Masuk
              </button>
              <button type="button" class="btn btn-danger btn-sm btn-barang-keluar" data-bs-toggle="modal"
                data-bs-target="#modalBarangKeluar">
                Barang Keluar
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="datatable" class="table table-striped table-hover word-wrap" data-toggle="data-table">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Stok Saat Ini</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transactions as $transaction)
                    @php
                      $stockAfter = (int) $transaction->stock_after;
                      if ($stockAfter > 0) {
                          $statusLabel = 'Tersedia';
                          $statusClass = 'bg-success';
                      } else {
                          $statusLabel = 'Tidak Tersedia';
                          $statusClass = 'bg-danger';
                      }
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y') : '-' }}
                      </td>
                      <td><span class="badge bg-primary">
                          {{ $transaction->product->code ?? '-' }}
                        </span>
                      </td>
                      <td>
                        <strong>{{ $transaction->product->name ?? '-' }}</strong>
                        @if ($transaction->note)
                          <br>
                          <small class="text-muted">
                            {{ Str::limit($transaction->note, 50) }}
                          </small>
                        @endif
                      </td>
                      <td>
                        {{ $transaction->product->category->name ?? '-' }}
                      </td>
                      <td>
                        @if ($transaction->type === 'masuk')
                          <span class="text-success fw-bold">
                            {{ number_format($transaction->quantity) }}
                            {{ $transaction->product->unit ?? '' }}
                          </span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td>
                        @if ($transaction->type === 'keluar')
                          <span class="text-danger fw-bold">
                            {{ number_format($transaction->quantity) }}
                            {{ $transaction->product->unit ?? '' }}
                          </span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td>
                        <strong>
                          {{ number_format($stockAfter) }}
                          {{ $transaction->product->unit ?? '' }}
                        </strong>
                      </td>
                      <td>
                        <span class="badge {{ $statusClass }}">
                          {{ $statusLabel }}
                        </span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Modal Barang Masuk --}}
  <div class="modal fade" id="modalBarangMasuk" tabindex="-1" aria-labelledby="modalBarangMasukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('inventory.transaction.store') }}" method="POST" id="formBarangMasuk">
          @csrf
          <input type="hidden" name="type" value="masuk">
          <div class="modal-header">
            <h5 class="modal-title" id="modalBarangMasukLabel">Form Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="transaction_date" id="tanggal_masuk" class="form-control"
                  value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Barang <span class="text-danger">*</span></label>
                <select name="product_id" id="product_masuk" class="form-select" required>
                  <option value="">Pilih Barang</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-unit="{{ e($product->unit) }}" data-stock="{{ $product->stock }}">
                      {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }} {{ $product->unit }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                <input type="number" name="quantity" id="quantity_masuk" class="form-control" min="1"
                  placeholder="Contoh: 120" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" id="unit_masuk" class="form-control" placeholder="Satuan barang" readonly>
                <small class="text-muted" id="stok_masuk_info">Pilih barang untuk melihat stok
                  saat ini.</small>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="note" class="form-control" rows="4" placeholder="Keterangan
barang masuk"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Barang Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Modal Barang Keluar --}}
  <div class="modal fade" id="modalBarangKeluar" tabindex="-1" aria-labelledby="modalBarangKeluarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('inventory.transaction.store') }}" method="POST" id="formBarangKeluar">
          @csrf
          <input type="hidden" name="type" value="keluar">
          <div class="modal-header">
            <h5 class="modal-title" id="modalBarangKeluarLabel">Form Barang Keluar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="transaction_date" id="tanggal_keluar" class="form-control"
                  value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Barang <span class="text-danger">*</span></label>
                <select name="product_id" id="product_keluar" class="form-select" required>
                  <option value="">Pilih Barang</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-unit="{{ e($product->unit) }}" data-stock="{{ $product->stock }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                      {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }} {{ $product->unit }}
                      {{ $product->stock <= 0 ? '| Tidak Tersedia' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Keluar <span class="text-danger">*</span></label>
                <input type="number" name="quantity" id="quantity_keluar" class="form-control" min="1"
                  placeholder="Contoh: 35" required>
                <small class="text-muted" id="stok_keluar_info">Pilih barang untuk melihat batas stok keluar.</small>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" id="unit_keluar" class="form-control" placeholder="Satuan
barang" readonly>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="note" class="form-control" rows="4" placeholder="Keterangan
barang keluar"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Simpan Barang Keluar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @push('scripts')
    <script>
      $(document).ready(function() {
        $('#product_masuk').on('change', function() {
          const selected = $(this).find(':selected');
          const unit = selected.data('unit') || '';
          const stock = selected.data('stock');
          $('#unit_masuk').val(unit);
          if ($(this).val()) {
            $('#stok_masuk_info').text('Stok saat ini: ' + stock + ' ' + unit);
          } else {
            $('#stok_masuk_info').text('Pilih barang untuk melihat stok saat ini.');
          }
        });
        $('#product_keluar').on('change', function() {
          const selected = $(this).find(':selected');
          const unit = selected.data('unit') || '';
          const stock = parseInt(selected.data('stock')) || 0;
          $('#unit_keluar').val(unit);
          if ($(this).val()) {
            $('#quantity_keluar').attr('max', stock);
            $('#stok_keluar_info').text('Maksimal barang keluar: ' + stock + ' ' + unit);
          } else {
            $('#quantity_keluar').removeAttr('max');
            $('#stok_keluar_info').text('Pilih barang untuk melihat batas stok keluar.');
          }
        });
        $('#formBarangKeluar').on('submit', function(e) {
          const selected = $('#product_keluar').find(':selected');
          const stock = parseInt(selected.data('stock')) || 0;
          const quantity = parseInt($('#quantity_keluar').val()) || 0;
          if (quantity > stock) {
            e.preventDefault();
            alert('Jumlah barang keluar tidak boleh melebihi stok tersedia.');
            return false;
          }
        });
        $('#modalBarangMasuk').on('hidden.bs.modal', function() {
          $('#formBarangMasuk')[0].reset();
          $('#unit_masuk').val('');
          $('#stok_masuk_info').text('Pilih barang untuk melihat stok saat ini.');
        });
        $('#modalBarangKeluar').on('hidden.bs.modal', function() {
          $('#formBarangKeluar')[0].reset();
          $('#unit_keluar').val('');
          $('#quantity_keluar').removeAttr('max');
          $('#stok_keluar_info').text('Pilih barang untuk melihat batas stok keluar.');
        });
      });
    </script>
  @endpush
@endsection
