@extends('layouts.pelanggan')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body p-5">

                    <div class="text-center mb-5">

                        <i class="bi bi-star-fill text-warning" style="font-size:60px"></i>

                        <h3 class="fw-bold mt-3">
                            Berikan Penilaian
                        </h3>

                        <p class="text-muted">
                            Bagaimana pengalaman Anda menggunakan layanan
                            <strong>{{ $order->mitra->business_name }}</strong>?
                        </p>

                    </div>

                    <form action="{{ route('review.store',$order->id) }}"
                          method="POST">

                        @csrf

                        <input type="hidden"
                               name="rating"
                               id="rating"
                               value="0">

                        <div class="text-center mb-4">

                            <div id="stars">

                                @for($i=1;$i<=5;$i++)

                                    <i class="bi bi-star star"
                                       data-value="{{ $i }}"
                                       style="
                                            font-size:50px;
                                            cursor:pointer;
                                            color:#ccc;
                                       "></i>

                                @endfor

                            </div>

                            <div class="mt-3">

                                <span id="rating-text"
                                      class="fw-bold text-secondary">

                                    Pilih Rating

                                </span>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Ulasan

                            </label>

                            <textarea
                                name="review"
                                class="form-control"
                                rows="5"
                                placeholder="Ceritakan pengalaman Anda..."
                                required></textarea>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="/my-orders/{{ $order->id }}"
                               class="btn btn-light">

                                Kembali

                            </a>

                            <button
                                class="btn btn-primary px-5">

                                Kirim Ulasan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let stars=document.querySelectorAll('.star');

let rating=document.getElementById('rating');

let text=document.getElementById('rating-text');

const labels={

1:'Sangat Buruk 😞',

2:'Kurang 😕',

3:'Cukup 🙂',

4:'Bagus 😄',

5:'Sangat Puas 🤩'

};

stars.forEach(star=>{

    star.addEventListener('click',function(){

        let value=this.dataset.value;

        rating.value=value;

        text.innerHTML=labels[value];

        stars.forEach(s=>{

            if(s.dataset.value<=value){

                s.classList.remove('bi-star');

                s.classList.add('bi-star-fill');

                s.style.color='#ffc107';

            }else{

                s.classList.remove('bi-star-fill');

                s.classList.add('bi-star');

                s.style.color='#ccc';

            }

        });

    });

});

</script>

@endsection