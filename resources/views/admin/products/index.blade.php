<td>
    @if ($product->thumbnail)
        <img src="{{ asset('storage/' . $product->thumbnail) }}" width="80">
    @else
        <small>Tidak ada gambar</small>
    @endif
</td>
