easyComm.window.getMessageWindowFields = function (config) {
    var availableFields = {
        user_name: { xtype: 'textfield', anchor: '99%', allowBlank: true },
        user_email: { xtype: 'textfield', anchor: '99%', allowBlank: true },
        date: { xtype: 'xdatetime', anchor: '99%', allowBlank: false },
        user_contacts: { xtype: 'textfield', anchor: '99%', allowBlank: true },
        subject: { xtype: 'textfield', anchor: '99%', allowBlank: true },
        rating: { xtype: 'numberfield', anchor: '99%', allowBlank: false, allowNegative: false, allowDecimals: false },
        text: { xtype: 'textarea', anchor: '99%', allowBlank: true, height: 120 },
        published: { xtype: 'xcheckbox', anchor: '99%', allowBlank: true },
        reply_author: { xtype: 'textfield', anchor: '99%', allowBlank: true },
        reply_text: { xtype: 'textarea', anchor: '99%', allowBlank: true, height: 200 },
        notify: { xtype: 'xcheckbox', anchor: '99%', allowBlank: true },
        notify_date: { xtype: 'displayfield', anchor: '99%' },
        thread: { xtype: 'ec-combo-thread', anchor: '99%', allowBlank: false },
        ip: { xtype: 'displayfield', anchor: '99%' },
        extended: { xtype: 'textarea', anchor: '99%', allowBlank: true }
    };

    var tabs = [];
    for (var tab_layout in easyComm.config.message_window_layout) {
        if (easyComm.config.message_window_layout.hasOwnProperty(tab_layout)) {
            var fields = [];
            var tab_layout = easyComm.config.message_window_layout[tab_layout];
            for (var tab_layout_prop in tab_layout) {
                if (tab_layout.hasOwnProperty(tab_layout_prop)) {
                    switch (tab_layout_prop) {
                        case 'fields':
                            for(var i = 0; i < tab_layout.fields.length; i++){
                                var f = tab_layout.fields[i];
                                if (availableFields[f]) {
                                    Ext.applyIf(availableFields[f], {
                                        fieldLabel: _('ec_message_' + f),
                                        name: f,
                                        id: config.id + '-' + f
                                    });
                                    fields.push(availableFields[f]);
                                }
                            }
                            break;
                        case 'columns':
                            var cols = [];
                            for (var column in tab_layout.columns) {
                                if (tab_layout.columns.hasOwnProperty(column)) {
                                    var c = tab_layout.columns[column];
                                    var colFields = [];
                                    for(var i = 0; i < c.length; i++){
                                        var f = c[i];
                                        if (availableFields[f]) {
                                            Ext.applyIf(availableFields[f], {
                                                fieldLabel: _('ec_message_' + f),
                                                name: f,
                                                id: config.id + '-' + f
                                            });
                                            colFields.push(availableFields[f]);
                                        }
                                    }
                                    cols.push({
                                        columnWidth: .5,
                                        border: false,
                                        layout: 'form',
                                        items: [colFields]
                                    });
                                }
                            }
                            if(cols.length > 0){
                                fields.push({
                                    layout: 'column',
                                    border: false,
                                    items: [cols]
                                });
                            }
                            break;
                    }
                }
            }
            tabs.push({
                title: _('ec_message_tab_' + tab_layout.name),
                layout: 'anchor',
                items: [{
                    layout: 'form',
                    cls: 'modx-panel',
                    items: [fields]
                }]
            });
        }
    }

    return [{
        xtype: 'modx-tabs',
        defaults: {border: false, autoHeight: true},
        deferredRender: false,
        border: true,
        hideMode: 'offsets',
        items: [tabs]
    }];
}

easyComm.window.CreateMessage = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-message-window-create';
    }
    Ext.applyIf(config, {
        title: _('ec_message_create'),
        width: 550,
        autoHeight: true,
        url: easyComm.config.connector_url,
        action: 'mgr/message/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    easyComm.window.CreateMessage.superclass.constructor.call(this, config);
};
Ext.extend(easyComm.window.CreateMessage, MODx.Window, {
    getFields: function (config) {
        return [
            {
                items: easyComm.window.getMessageWindowFields(config)
            }
        ];
    }
});
Ext.reg('ec-message-window-create', easyComm.window.CreateMessage);


easyComm.window.UpdateMessage = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-message-window-update';
    }
    Ext.applyIf(config, {
        title: _('ec_message_update'),
        width: 700,
        autoHeight: true,
        url: easyComm.config.connector_url,
        action: 'mgr/message/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    easyComm.window.UpdateMessage.superclass.constructor.call(this, config);
};
Ext.extend(easyComm.window.UpdateMessage, MODx.Window, {
    getFields: function (config) {
        return [
            { xtype: 'hidden', name: 'id', id: config.id + '-id' },
            {
                items: easyComm.window.getMessageWindowFields(config)
            }
        ];
    }
});
Ext.reg('ec-message-window-update', easyComm.window.UpdateMessage);