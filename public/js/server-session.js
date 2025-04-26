class ServerSession {

    constructor() {
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    retrieve(data, callback) {
        const context = this
        $.ajax({
            type: "POST",
            url: "/session/retrieve",
            data: data,
            success: (data) => {
                if ("function" == typeof callback) {
                    callback.call(context, data)
                }
            },
            dataType: "json",
        })
    }

    store(data, callback) {
        const context = this
        $.ajax({
            type: "POST",
            url: "/session/store",
            data: data,
            success: (data) => {
                if ("function" == typeof callback) {
                    callback.call(context, data)
                }
            },
            dataType: "json",
        })
    }
}
