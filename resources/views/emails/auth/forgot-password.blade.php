<div style="background:#f3f3f3;padding:40px 0;font-family:'Ubuntu', sans-serif;">
    <div style="max-width:90%;margin:0 auto;">
        <h1 style="font-family:'Fira Sans', sans-serif;">Здравей, {{ $name }}!</h1>
        <p>
            Някой скоро поиска да възстанови паролата ти в <strong>Dasher</strong>
        </p>
        <p>
            Ако не искаш да възстановиш паролата си, можеш спокойно да игнорираш този мейл, паролата ти няма да бъда
            променена, освен ако не бъде използван този линк:
        </p>
        <div style="margin:30px 0;">
            <a href="{{ $link }}" title="Възстанови парола"
               style="padding:10px 30px;background:blue;color:#fff;text-decoration:none;">Възстанови парола</a>
        </div>
        <div style="font-size: 16px; font-weight: 400;">
            <p>
                Моля имай предвид, че линкът ще изтече след <strong>2 часа</strong> и можеш да го ползваш <strong>само
                    веднъж</strong>
            </p>
            <p>
                Ако искаш да копираш линка ръчно: <a href="{{$link}}" title="Възстанови парола">{{ $link }}</a>
            </p>
        </div>
    </div>
</div>
