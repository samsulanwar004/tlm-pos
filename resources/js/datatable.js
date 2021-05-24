const columnOptions = [
    "cellType",
    "className",
    "contentPadding",
    "createdCell",
    "data",
    "defaultContent",
    "name",
    "orderable",
    "orderData",
    "orderDataType",
    "render",
    "searchable",
    "title",
    "type",
    "visible",
    "width"
];

const getColumnDataAttributes = (tableSelector = ".datatable-serverside") => {
    return $(tableSelector)
        .find("thead > tr > *")
        .map((_i, el) =>
            columnOptions.reduce((obj, key) => {
                const val = el.dataset[key];

                if (val === undefined) {
                    return obj;
                }

                const boleanIndex = ["true", "false"].indexOf(
                    val.toLowerCase()
                );

                return {
                    ...obj,
                    [key]: boleanIndex < 0 ? val : boleanIndex === 0
                };
            }, {})
        )

        .toArray();
};

window.initDatatable = (tableSelector, options = {}) => {
    const columns = getColumnDataAttributes(tableSelector);

    return $(tableSelector).DataTable({
        dom: `<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>
                <'table-responsive'tr>
                <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>`,
        language: {
            paginate: {
                previous: '<i class="fa fa-lg fa-angle-left"></i>',
                next: '<i class="fa fa-lg fa-angle-right"></i>'
            }
        },
        autoWidth: true,
        searching: true,
        serverSide: true,
        processing: true,
        deferRender: true,
        ajax: {
            url: location.href
        },
        columns: columns,
        ...options
    });
};
