easyComm.combo.ThreadResource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        fields: ['id','title']
        ,valueField: 'id'
        ,displayField: 'title'
        ,hiddenName: 'resource'
        ,allowBlank: false
        ,url: easyComm.config.connector_url
        ,baseParams: {
            action: 'mgr/system/element/resource/getlist'
            ,combo: 1
            ,id: config.value
        }
        ,pageSize: 20
        ,width: 300
        ,editable: true
    });
    easyComm.combo.ThreadResource.superclass.constructor.call(this,config);
};
Ext.extend(easyComm.combo.ThreadResource,MODx.combo.ComboBox);
Ext.reg('ec-combo-resource',easyComm.combo.ThreadResource);

easyComm.combo.MessageThread = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        fields: ['id','title']
        ,valueField: 'id'
        ,displayField: 'title'
        ,hiddenName: 'thread'
        ,allowBlank: false
        ,url: easyComm.config.connector_url
        ,baseParams: {
            action: 'mgr/thread/getcombolist'
            ,combo: 1
            ,id: config.value
        }
        ,pageSize: 20
        ,width: 300
        ,editable: true
    });
    easyComm.combo.ThreadResource.superclass.constructor.call(this,config);
};
Ext.extend(easyComm.combo.MessageThread,MODx.combo.ComboBox);
Ext.reg('ec-combo-thread',easyComm.combo.MessageThread);

easyComm.utils.renderBoolean = function (value, props, row) {
	return value
		? String.format('<span class="green">{0}</span>', _('yes'))
		: String.format('<span class="red">{0}</span>', _('no'));
}