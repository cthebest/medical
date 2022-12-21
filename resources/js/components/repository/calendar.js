export function buildDays(monthShow, today) {
    let start_day = monthShow.clone().startOf('month').startOf('week').day(0);
    const end_day = monthShow.clone().endOf('month').endOf('week').day(6);

    let days = [];
    while (start_day < end_day) {
        const day = {
            isValid: start_day.isSameOrAfter(today, 'date'),
            date: start_day.format('YYYY-MM-DD'),
            number: start_day.format('D'),
            isToday: today.isSame(start_day, 'date'),
            isInCurrentMonth: start_day.month() === monthShow.month()
        }
        days.push(day);
        start_day = start_day.clone().add(1, 'd');
    }
    return {
        month_name: monthShow.format('MMM YYYY'),
        year: monthShow.format('YYYY'),
        days
    }
}
