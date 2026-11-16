/**
 * Information of BMKG — Multi-Language Support (i18n)
 * Official BMKG Information Center System
 * Supported: ID (Bahasa Indonesia), EN (English), JA (日本語), ZH (中文), AR (العربية), ES (Español)
 */

const translations = {
    appTitle: {
        id: 'Information of BMKG',
        en: 'Information of BMKG',
        ja: 'BMKG 気象情報センター',
        zh: 'BMKG 气象信息中心',
        ar: 'معلومات الأرصاد الجوية الإندونيسية',
        es: 'Información de BMKG',
    },
    appSubtitle: {
        id: 'Badan Meteorologi, Klimatologi, dan Geofisika',
        en: 'Meteorology, Climatology, and Geophysical Agency',
        ja: 'インドネシア気象気候地球物理庁',
        zh: '印度尼西亚气象、气候和地球物理局',
        ar: 'وكالة الأرصاد الجوية وعلم المناخ والجيوفيزياء',
        es: 'Agencia de Meteorología, Climatología y Geofísica',
    },
    dashboard: { id: 'Dashboard', en: 'Dashboard', ja: 'ダッシュボード', zh: '仪表板', ar: 'لوحة القيادة', es: 'Tablero' },
    map: { id: 'Peta Cuaca', en: 'Weather Map', ja: '気象マップ', zh: '天气地图', ar: 'خريطة الطقس', es: 'Mapa del Clima' },
    forecast: { id: 'Prakiraan', en: 'Forecast', ja: '天気予報', zh: '天气预报', ar: 'التوقعات', es: 'Pronóstico' },
    airquality: { id: 'Kualitas Udara', en: 'Air Quality', ja: '大気質', zh: '空气质量', ar: 'جودة الهواء', es: 'Calidad del Aire' },
    alerts: { id: 'Peringatan Dini', en: 'Early Warnings', ja: '早期警報', zh: '早期预警', ar: 'الإنذار المبكر', es: 'Alertas Tempranas' },
    analytics: { id: 'Analisis Cuaca', en: 'Analytics', ja: '気象分析', zh: '气象分析', ar: 'التحليلات', es: 'Análisis' },
    compare: { id: 'Bandingkan', en: 'Compare', ja: '都市比較', zh: '对比分析', ar: 'مقارنة', es: 'Comparar' },
    maritime: { id: 'Maritim & Kelautan', en: 'Marine & Maritime', ja: '海洋気象', zh: '海洋气象', ar: 'الأرصاد البحرية', es: 'Marítimo' },
    aviation: { id: 'Penerbangan', en: 'Aviation', ja: '航空気象', zh: '航空气象', ar: 'طيران', es: 'Aviación' },
    earthquake: { id: 'Gempa BMKG', en: 'Earthquakes', ja: '地震情報', zh: '地震监测', ar: 'الزلازل', es: 'Terremotos' },
    hiking: { id: 'Pendakian Gunung', en: 'Mountain Hiking', ja: '登山気象', zh: '登山天气', ar: 'تسلق الجبال', es: 'Senderismo' },
    driving: { id: 'Berkendara Aman', en: 'Safe Driving', ja: '運転安全', zh: '安全驾驶', ar: 'القيادة الآمنة', es: 'Conducción Segura' },
    outdoor: { id: 'Indeks Outdoor', en: 'Outdoor Index', ja: 'アウトドア指数', zh: '户外指数', ar: 'مؤشر الهواء الطلق', es: 'Índice al Aire Libre' },
    pollen: { id: 'Serbuk Sari & Alergi', en: 'Pollen Index', ja: '花粉情報', zh: '花粉指数', ar: 'حبوب اللقاح', es: 'Polen' },
    history: { id: 'Histori Cuaca', en: 'History', ja: '過去の気象', zh: '历史天气', ar: 'سجل الطقس', es: 'Historial' },
    aiAssistant: { id: 'Fitur AI', en: 'AI Assistant', ja: 'AIアシスタント', zh: 'AI 气象助手', ar: 'مساعد الذكاء الاصطناعي', es: 'Asistente IA' },
    settings: { id: 'Pengaturan & API', en: 'Settings & API', ja: '設定とAPI', zh: '设置与API', ar: 'الإعدادات وواجهة برمجة التطبيقات', es: 'Configuración y API' },
    searchPlaceholder: {
        id: 'Cari nama kota, kabupaten, atau kecamatan di Indonesia...',
        en: 'Search city, regency, or district in Indonesia...',
        ja: 'インドネシアの都市・地域を検索...',
        zh: '搜索印尼城市、区县...',
        ar: 'ابحث عن مدينة أو منطقة في إندونيسيا...',
        es: 'Buscar ciudad o distrito en Indonesia...',
    },
    liveBadge: { id: 'LIVE', en: 'LIVE', ja: 'ライブ', zh: '实时', ar: 'مباشر', es: 'EN VIVO' },
    humidity: { id: 'Kelembapan Udara', en: 'Humidity', ja: '湿度', zh: '空气湿度', ar: 'الرطوبة', es: 'Humedad' },
    windSpeed: { id: 'Kecepatan Angin', en: 'Wind Speed', ja: '風速', zh: '风速', ar: 'سرعة الرياح', es: 'Velocidad del Viento' },
    airPressure: { id: 'Tekanan Udara', en: 'Air Pressure', ja: '気圧', zh: '气压', ar: 'الضغط الجوي', es: 'Presión Atmosférica' },
    visibility: { id: 'Jarak Pandang', en: 'Visibility', ja: '視程', zh: '能见度', ar: 'مدى الرؤية', es: 'Visibilidad' },
    feelsLike: { id: 'Terasa seperti', en: 'Feels like', ja: '体感温度', zh: '体感温度', ar: 'تشعر وكأنها', es: 'Sensación térmica' },
    uvIndex: { id: 'Indeks UV', en: 'UV Index', ja: 'UV指数', zh: '紫外线指数', ar: 'مؤشر الأشعة فوق البنفسجية', es: 'Índice UV' },
    forecast7d: { id: 'Prakiraan Cuaca 7 Hari ke Depan', en: '7-Day Weather Forecast', ja: '7日間の天気予報', zh: '未来7天天气预报', ar: 'توقعات الطقس لـ 7 أيام', es: 'Pronóstico de 7 Días' },
    hourlyForecast: { id: 'Prakiraan 24 Jam', en: '24-Hour Forecast', ja: '24時間予報', zh: '24小时逐时预报', ar: 'توقعات 24 ساعة', es: 'Pronóstico 24 Horas' },
    recommendationTitle: { id: 'Rekomendasi Warga', en: 'Resident Recommendations', ja: 'おすすめ活動', zh: '居民生活建议', ar: 'توصيات للمواطنين', es: 'Recomendaciones' },
    airQualityTitle: { id: 'Kualitas Udara Terkini', en: 'Current Air Quality', ja: '現在の大気質', zh: '当前空气质量', ar: 'جودة الهواء الحالية', es: 'Calidad del Aire' },
    safeOutdoor: { id: 'Udara bersih. Aman untuk beraktivitas di luar ruangan.', en: 'Clean air. Safe for outdoor activities.', ja: '空気は良好です。屋外活動に適しています。', zh: '空气良好，适宜户外活动。', ar: 'الهواء نقي. آمن للأنشطة الخارجية.', es: 'Aire limpio. Seguro para actividades al aire libre.' },
    viewDetails: { id: 'Lihat Detail', en: 'View Details', ja: '詳細を見る', zh: '查看详情', ar: 'عرض التفاصيل', es: 'Ver Detalles' },
    viewAll: { id: 'Lihat Semua', en: 'View All', ja: 'すべて見る', zh: '查看全部', ar: 'عرض الكل', es: 'Ver Todo' },
    radarActive: { id: 'Radar Atmosfer BMKG Aktif', en: 'BMKG Radar Active', ja: 'BMKGレーダー稼働中', zh: 'BMKG 气象雷达运行中', ar: 'رادار الأرصاد الجوية نشط', es: 'Radar BMKG Activo' },
    premiumSector: { id: 'Fitur Utama & Sektor Khusus', en: 'Key Modules & Specialized Sectors', ja: '主要機能と専門セクター', zh: '主要功能与专业领域', ar: 'القطاعات والخدمات الرئيسية', es: 'Sectores Especializados' },
    lastUpdated: { id: 'Pembaruan Terakhir', en: 'Last Updated', ja: '最終更新', zh: '最后更新', ar: 'آخر تحديث', es: 'Última actualización' },
    darkMode: { id: 'Mode Gelap', en: 'Dark Mode', ja: 'ダークモード', zh: '深色模式', ar: 'الوضع الداكن', es: 'Modo Oscuro' },
    lightMode: { id: 'Mode Terang', en: 'Light Mode', ja: 'ライトモード', zh: '浅色模式', ar: 'الوضع الفاتح', es: 'Modo Claro' },
};

const supportedLanguages = [
    { code: 'id', name: 'Bahasa Indonesia', flag: '🇮🇩' },
    { code: 'en', name: 'English', flag: '🇬🇧' },
    { code: 'ja', name: '日本語', flag: '🇯🇵' },
    { code: 'zh', name: '中文', flag: '🇨🇳' },
    { code: 'ar', name: 'العربية', flag: '🇸🇦' },
    { code: 'es', name: 'Español', flag: '🇪🇸' },
];

const getLang = () => {
    try {
        return localStorage.getItem('wl_lang') || 'id';
    } catch (e) {
        return 'id';
    }
};

const setLang = (code) => {
    try {
        localStorage.setItem('wl_lang', code);
    } catch (e) {}
};

const t = (key) => {
    const lang = getLang();
    const entry = translations[key];
    if (!entry) return key;
    return entry[lang] || entry.en || entry.id || key;
};

const applyI18n = () => {
    const lang = getLang();
    document.documentElement.setAttribute('lang', lang);
    if (lang === 'ar') {
        document.documentElement.setAttribute('dir', 'rtl');
    } else {
        document.documentElement.setAttribute('dir', 'ltr');
    }

    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        const val = t(key);
        if (val && val !== key) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = val;
            } else {
                el.textContent = val;
            }
        }
    });

    // Update switcher flags & labels
    const flagEls = document.querySelectorAll('[data-lang-flag]');
    const found = supportedLanguages.find(l => l.code === lang) || supportedLanguages[0];
    flagEls.forEach(el => {
        el.textContent = found.flag;
    });

    const labelEls = document.querySelectorAll('[data-lang-name]');
    labelEls.forEach(el => {
        el.textContent = found.name;
    });
};

if (typeof window !== 'undefined') {
    window.WL = window.WL || {};
    window.WL.t = t;
    window.WL.setLang = setLang;
    window.WL.getLang = getLang;
    window.WL.applyI18n = applyI18n;
    window.WL.supportedLanguages = supportedLanguages;
    window.WL.translations = translations;
    document.addEventListener('DOMContentLoaded', applyI18n);
}

export { t, setLang, getLang, applyI18n, supportedLanguages, translations };
