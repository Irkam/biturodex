from django.contrib.auth.models import User, Group
from rest_framework import serializers
from biturodex.models import Establishment, Event


class UserSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = User
        fields = ('url', 'username', 'email', 'groups')

class EstablishmentSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Establishment
        fields = ('name',)

class EventSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Event
        fields = ('name',)