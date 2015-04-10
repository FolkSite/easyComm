easyComm.window.CreateThread = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-thread-window-create';
    }
    Ext.applyIf(config, {
        title: _('ec_thread_create'),
        width: 550,
        autoHeight: true,
        url: easyComm.config.connector_url,
        action: 'mgr/thread/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    easyComm.window.CreateThread.superclass.constructor.call(this, config);
};
Ext.extend(easyComm.window.CreateThread, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype:'ec-combo-resource',
            fieldLabel: _('ec_thread_resource'),
            name: 'resource',
            id: config.id + '-resource',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('ec_thread_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('ec_thread_title'),
            name: 'title',
            id: config.id + '-title',
            anchor: '99%',
            allowBlank: true
        }, {
            xtype: 'textarea',
            fieldLabel: _('ec_thread_extended'),
            name: 'extended',
            id: config.id + '-extended',
            anchor: '99%',
            allowBlank: true
        }];
    }

});
Ext.reg('ec-thread-window-create', easyComm.window.CreateThread);


easyComm.window.UpdateThread = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-thread-window-update';
    }
    Ext.applyIf(config, {
        title: _('ec_thread_update'),
        width: 550,
        autoHeight: true,
        url: easyComm.config.connector_url,
        action: 'mgr/thread/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    easyComm.window.UpdateThread.superclass.constructor.call(this, config);
};
Ext.extend(easyComm.window.UpdateThread, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype:'ec-combo-resource',
            fieldLabel: _('ec_thread_resource'),
            name: 'resource',
            id: config.id + '-resource',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('ec_thread_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('ec_thread_title'),
            name: 'title',
            id: config.id + '-title',
            anchor: '99%',
            allowBlank: true
        }, {
            xtype: 'textarea',
            fieldLabel: _('ec_thread_extended'),
            name: 'extended',
            id: config.id + '-extended',
            anchor: '99%',
            allowBlank: true
        }, {
            xtype: 'displayfield',
            fieldLabel: _('ec_thread_rating_simple'),
            name: 'rating_simple',
            id: config.id + '-rating_simple',
            anchor: '99%'
        }, {
            xtype: 'displayfield',
            fieldLabel: _('ec_thread_rating_wilson'),
            name: 'rating_wilson',
            id: config.id + '-rating_wilson',
            anchor: '99%'
        }];
    }

});
Ext.reg('ec-thread-window-update', easyComm.window.UpdateThread);