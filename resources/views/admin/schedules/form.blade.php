<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="field_id">Pilih Lapangan</label>
        <select name="field_id" class="form-control" required>
            <option value="">-- Pilih --</option>
            @foreach ($fields as $field)
                <option value="{{ $field->id }}"
                    @if (old('field_id', $schedule->field_id ?? '') == $field->id) selected @endif>
                    {{ $field->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="day_of_week">Hari</label>
        <input type="text" name="day_of_week" class="form-control" value="{{ old('day_of_week', $schedule->day_of_week ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="start_time">Jam Mulai</label>
        <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $schedule->start_time ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="end_time">Jam Selesai</label>
        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $schedule->end_time ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="is_available">Tersedia?</label>
        <select name="is_available" class="form-control" required>
            <option value="1" {{ old('is_available', $schedule->is_available ?? '') == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ old('is_available', $schedule->is_available ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Kembali</a>
</form>
