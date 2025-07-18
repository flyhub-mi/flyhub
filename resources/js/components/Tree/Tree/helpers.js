export const startIsOpen = (items, setState, isOpen = true) => {
    setState(items.map(item => ({ id: item.id, isOpen })));
};

export const isOpen = (item, state) => {
    return state.some(stateItem => item.id === stateItem.id && stateItem.isOpen);
};

export const toggleIsOpen = (item, state, setState) => {
    setState(
        state.map(stateItem => (item.id === stateItem.id ? { ...stateItem, isOpen: !stateItem.isOpen } : stateItem))
    );
};

export const getSelectedClass = (data, selected, darkMode) => {
    let selectedClass = null;
    const dId = data && data.id ? data.id : null;
    const sId = selected && selected.id ? selected.id : null;
    const darkClass = darkMode ? 'dark' : 'light';

    if (sId && dId) {
        selectedClass = sId === dId ? 'T-' + darkClass + '-highlight' : null;
    }

    return selectedClass;
};
