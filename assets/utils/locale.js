import { defaultLocale, availableLocales } from "@/config/defaults";
import { useI18n } from "vue-i18n";

export const getInitialLocale = () => {
    const currentQuery = window.location.pathname;
    const splittedQuery = currentQuery.split('/');
    if (splittedQuery[1] && availableLocales.indexOf(splittedQuery[1]) >= 0) {
        // Locale from url
        return  splittedQuery[1];
    } else {
        // Locale from storage or default locale
        const storedLocale = localStorage.getItem('locale')
        return storedLocale ? storedLocale : defaultLocale
    }
}

export const getGlobalLocale = () => {
    const i18n = useI18n({ useScope: 'global' });
    return i18n.locale.value
}