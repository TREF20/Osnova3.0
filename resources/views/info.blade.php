@extends('layouts.app')

@section('content')
    <section class="info-section" style="padding: 120px 0; background: linear-gradient(to bottom, #fffaf5, #f8f0e8);">
        <div class="container">
            <h1 class="section-title">О нас</h1>
            
            <div class="info-content">
                <p class="info-slogan">«Одежда в которой живут каждый день»</p>
                
                <p class="info-description">
                    Комфорт и стиль без лишнего. Просто и по делу. 
                    Приходи к нам, выбирай себе стильный образ и на кассе по промокоду «НОВИЧОК» получай скидку 300₽ на первую покупку!
                </p>
                
                <p class="info-description">
                    Также у нас в Перми есть магазин одежды сайз плюс и для девушек с 42-50 размера возраста 40+. Пиши, скажем куда идти ☺️
                </p>
                
                <div class="info-contacts">
                    <div class="contact-item">
                        <span class="contact-icon"></span>
                        Номер телефона: +7 (952) 653-72-53
                    </div>
                    
                    <div class="contact-item">
                        <span class="contact-icon"></span>
                        Адрес: Крупской, 42, Пермь
                    </div>
                </div>
                
                <!-- Карта адреса -->
                <div class="info-map" style="margin-top: 60px; text-align: center;">
                    <h3 class="map-title" style="font-size: 2rem; color: #2c1f1a; margin-bottom: 30px;">Наша карта</h3>
                    <img src="https://static-maps.yandex.ru/1.x/?ll=56.281753%2C58.013376&z=16&size=600%2C450&l=map&pt=56.281753%2C58.013376%2Cpm2rdm" 
                         alt="Карта адреса Крупской, 42, Пермь" 
                         style="border-radius: 20px; box-shadow: 0 10px 30px rgba(212,122,143,0.15); max-width: 100%;">
                    <p style="margin-top: 20px; font-size: 1.1rem; color: #5c4639;">
                        Кликни на карту, чтобы открыть в Yandex Maps: 
                        <a href="https://yandex.ru/maps/?text=Крупской%2C%2042%2C%20Пермь" target="_blank" style="color: #d47a8f; text-decoration: underline;">Открыть полную карту</a>
                    </p>
                </div>
                
                <div class="info-socials" style="margin-top: 80px;">
                    <h3 class="social-title">Мы в соцсетях</h3>
                    <div class="social-links">
                        <a href="https://vk.com/osnova.perm" class="social-link" target="_blank">
                            <span class="social-icon"></span> @osnova.perm (ВКонтакте)
                        </a>
                        
                        <a href="https://www.instagram.com/ваш-инста" class="social-link" target="_blank">
                            <span class="social-icon"></span> @ваш-инста (Instagram)
                        </a>
                        
                        <a href="https://t.me/ваш-телеграм" class="social-link" target="_blank">
                            <span class="social-icon"></span> @ваш-телеграм (Telegram)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection