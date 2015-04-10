easyComm.window.getMessageWindowFields = function (config) {
    return [{
        xtype: 'modx-tabs',
        defaults: {border: false, autoHeight: true},
        deferredRender: false,
        border: true,
        hideMode: 'offsets',
        items: [{
            title: _('ec_message_tab_main'),
            layout: 'anchor',
            items: [{
                layout: 'form',
                cls: 'modx-panel',
                items: [{
                    layout: 'column',
                    border: false,
                    items: [{
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        items: [
                            { xtype: 'textfield', fieldLabel: _('ec_message_user_name'), name: 'user_name', id: config.id + '-user_name', anchor: '99%', allowBlank: true },
                            { xtype: 'textfield', fieldLabel: _('ec_message_user_email'), name: 'user_email', id: config.id + '-user_email', anchor: '99%', allowBlank: true }
                        ]
                    }, {
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        items: [
                            { xtype: 'xdatetime', fieldLabel: _('ec_message_date'), name: 'date', id: config.id + '-date', anchor: '99%', allowBlank: false },
                            { xtype: 'textfield', fieldLabel: _('ec_message_user_contacts'), name: 'user_contacts', id: config.id + '-user_contacts', anchor: '99%', allowBlank: true }
                        ]
                    }]
                },
                    { xtype: 'textfield', fieldLabel: _('ec_message_subject'), name: 'subject', id: config.id + '-subject', anchor: '99%', allowBlank: true },
                    { xtype: 'numberfield', fieldLabel: _('ec_message_rating'), name: 'rating', id: config.id + '-rating', anchor: '99%', allowBlank: false, allowNegative: false, allowDecimals: false },
                    { xtype: 'textarea', fieldLabel: _('ec_message_text'), name: 'text', id: config.id + '-text', anchor: '99%', allowBlank: true, height: 120 },
                    { xtype: 'xcheckbox', fieldLabel: _('ec_object_published'), name: 'published', id: config.id + '-published', anchor: '99%', allowBlank: true }
                ]
            }]
        }, {
            title: _('ec_message_tab_reply'),
            layout: 'anchor',
            items: [{
                layout: 'form',
                cls: 'modx-panel',
                items: [
                    { xtype: 'textfield', fieldLabel: _('ec_message_reply_author'), name: 'reply_author', id: config.id + '-reply_author', anchor: '99%', allowBlank: true },
                    { xtype: 'textarea', fieldLabel: _('ec_message_reply_text'), name: 'reply_text', id: config.id + '-reply_text', anchor: '99%', allowBlank: true, height: 200 },
                    { xtype: 'xcheckbox', fieldLabel: _('ec_message_notify'), name: 'notify', id: config.id + '-notify', anchor: '99%', allowBlank: true },
                    { xtype: 'displayfield', fieldLabel: _('ec_message_notify_date'), name: 'notify_date', id: config.id + '-notify_date', anchor: '99%' }
                ]
            }]
        }, {
            title: _('ec_message_tab_settings'),
            layout: 'anchor',
            items: [{
                layout: 'form',
                cls: 'modx-panel',
                items: [
                    { xtype:'ec-combo-thread', fieldLabel: _('ec_message_thread'), name: 'thread', id: config.id + '-thread', anchor: '99%', allowBlank: false },
                    { xtype: 'displayfield', fieldLabel: _('ec_message_ip'), name: 'ip', id: config.id + '-ip', anchor: '99%' },
                    { xtype: 'textarea', fieldLabel: _('ec_message_extended'), name: 'extended', id: config.id + '-extended', anchor: '99%', allowBlank: true }
                ]
            }]
        }]
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